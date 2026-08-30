<?php

namespace App\Services;

use App\Enums\ClaimStatus;
use App\Models\Claim;
use App\Models\Commodity;
use App\Models\CommodityPrice;
use App\Models\Country;
use App\Models\ExchangeRate;
use App\Models\Market;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function todayPriceCount(?int $countryId = null): int
    {
        return $this->applyCountryFilterToPriceQuery(
            CommodityPrice::query()->whereDate('price_date', today()),
            $countryId,
        )->count();
    }

    public function todayExchangeRateCount(?int $countryId = null): int
    {
        return $this->applyCountryFilterToExchangeRateQuery(
            ExchangeRate::query()->whereDate('rate_date', today()),
            $countryId,
        )->count();
    }

    /**
     * @return array{expected: int, actual: int, percentage: float}
     */
    public function priceCollectionCompletion(?int $countryId = null): array
    {
        $summary = $this->countryCollectionSummary($countryId);

        $expected = (int) collect($summary)->sum('expected');
        $actual = (int) collect($summary)->sum('actual');

        return [
            'expected' => $expected,
            'actual' => $actual,
            'percentage' => $this->calculatePercentage($actual, $expected),
        ];
    }

    /**
     * @return list<array{country_id: int, country_name: string, expected: int, actual: int, percentage: float}>
     */
    public function countryCollectionSummary(?int $countryId = null): array
    {
        $commodityCount = Commodity::query()->where('is_active', true)->count();
        $today = today()->toDateString();

        $countries = Country::query()
            ->when($countryId, fn (Builder $query) => $query->whereKey($countryId))
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        $marketCounts = Market::query()
            ->select('country_id', DB::raw('COUNT(*) as market_count'))
            ->where('is_active', true)
            ->when($countryId, fn (Builder $query) => $query->where('country_id', $countryId))
            ->groupBy('country_id')
            ->pluck('market_count', 'country_id');

        $priceRows = CommodityPrice::query()
            ->join('markets', 'markets.id', '=', 'commodity_prices.market_id')
            ->whereDate('commodity_prices.price_date', $today)
            ->when($countryId, fn (Builder $query) => $query->where('markets.country_id', $countryId))
            ->get(['markets.country_id', 'commodity_prices.market_id', 'commodity_prices.commodity_id']);

        $actualCounts = $priceRows
            ->groupBy('country_id')
            ->map(fn (Collection $group) => $group->unique(
                fn ($row) => $row->market_id.'-'.$row->commodity_id
            )->count());

        return $countries->map(function (Country $country) use ($commodityCount, $marketCounts, $actualCounts): array {
            $expected = (int) ($marketCounts[$country->id] ?? 0) * $commodityCount;
            $actual = (int) ($actualCounts[$country->id] ?? 0);

            return [
                'country_id' => $country->id,
                'country_name' => $country->name,
                'expected' => $expected,
                'actual' => $actual,
                'percentage' => $this->calculatePercentage($actual, $expected),
            ];
        })->values()->all();
    }

    /**
     * @return Collection<int, ExchangeRate>
     */
    public function latestExchangeRates(?int $countryId = null): Collection
    {
        $latestIds = ExchangeRate::query()
            ->select(DB::raw('MAX(id) as id'))
            ->when($countryId, fn (Builder $query) => $query->where('country_id', $countryId))
            ->groupBy('country_id', 'base_currency_id', 'quote_currency_id')
            ->pluck('id');

        return ExchangeRate::query()
            ->whereIn('id', $latestIds)
            ->when($countryId, fn (Builder $query) => $query->where('country_id', $countryId))
            ->orderByDesc('rate_date')
            ->get();
    }

    /**
     * @return array{total: int, unresolved: int, by_status: array<string, int>}
     */
    public function claimSummary(?int $countryId = null): array
    {
        $claims = Claim::query()
            ->when($countryId, fn (Builder $query) => $query->where('country_id', $countryId))
            ->get(['status']);

        $byStatus = $claims
            ->groupBy(fn ($claim) => $claim->status instanceof ClaimStatus ? $claim->status->value : (string) $claim->status)
            ->map(fn (Collection $group) => $group->count())
            ->all();

        $unresolvedStatuses = [
            ClaimStatus::Submitted->value,
            ClaimStatus::UnderReview->value,
            ClaimStatus::Pending->value,
        ];

        $unresolved = collect($byStatus)
            ->only($unresolvedStatuses)
            ->sum();

        return [
            'total' => $claims->count(),
            'unresolved' => (int) $unresolved,
            'by_status' => $byStatus,
        ];
    }

    /**
     * @return Collection<int, array{type: string, description: string, occurred_at: Carbon, meta: array<string, mixed>}>
     */
    public function recentActivity(?int $countryId = null, int $limit = 10): Collection
    {
        $priceActivity = $this->applyCountryFilterToPriceQuery(
            CommodityPrice::query()->latest(),
            $countryId,
        )
            ->limit($limit)
            ->get()
            ->map(fn (CommodityPrice $price): array => [
                'type' => 'price',
                'description' => __('Commodity price recorded'),
                'occurred_at' => $price->created_at ?? now(),
                'meta' => [
                    'commodity_price_id' => $price->id,
                    'market_id' => $price->market_id,
                    'created_by' => $price->created_by,
                ],
            ]);

        $rateActivity = $this->applyCountryFilterToExchangeRateQuery(
            ExchangeRate::query()->latest(),
            $countryId,
        )
            ->limit($limit)
            ->get()
            ->map(fn (ExchangeRate $rate): array => [
                'type' => 'exchange_rate',
                'description' => __('Exchange rate updated'),
                'occurred_at' => $rate->created_at ?? now(),
                'meta' => [
                    'exchange_rate_id' => $rate->id,
                    'country_id' => $rate->country_id,
                    'created_by' => $rate->created_by,
                ],
            ]);

        $claimActivity = Claim::query()
            ->when($countryId, fn (Builder $query) => $query->where('country_id', $countryId))
            ->latest()
            ->limit($limit)
            ->get()
            ->map(fn (Claim $claim): array => [
                'type' => 'claim',
                'description' => sprintf(
                    'New claim %s submitted',
                    $claim->reference_number,
                ),
                'occurred_at' => $claim->created_at ?? now(),
                'meta' => [
                    'claim_id' => $claim->id,
                    'reference_number' => $claim->reference_number,
                ],
            ]);

        return $priceActivity
            ->concat($rateActivity)
            ->concat($claimActivity)
            ->sortByDesc('occurred_at')
            ->take($limit)
            ->values();
    }

    private function applyCountryFilterToPriceQuery(Builder $query, ?int $countryId): Builder
    {
        if ($countryId === null) {
            return $query;
        }

        return $query->whereIn('market_id', function ($subQuery) use ($countryId): void {
            $subQuery->select('id')
                ->from('markets')
                ->where('country_id', $countryId);
        });
    }

    private function applyCountryFilterToExchangeRateQuery(Builder $query, ?int $countryId): Builder
    {
        if ($countryId === null) {
            return $query;
        }

        return $query->where('country_id', $countryId);
    }

    private function calculatePercentage(int $actual, int $expected): float
    {
        if ($expected === 0) {
            return 0.0;
        }

        return round(($actual / $expected) * 100, 1);
    }
}
