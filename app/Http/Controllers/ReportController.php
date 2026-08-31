<?php

namespace App\Http\Controllers;

use App\Concerns\ResolvesCountryFilter;
use App\Enums\ClaimStatus;
use App\Models\Claim;
use App\Models\Commodity;
use App\Models\CommodityPrice;
use App\Models\Country;
use App\Models\ExchangeRate;
use App\Models\Market;
use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    use ResolvesCountryFilter;

    public function index(Request $request, DashboardService $dashboardService): View
    {
        abort_unless($request->user()?->can('reports.view'), 403);

        $countryId = $this->resolveCountryId($request);

        return view('msl.reports.index', [
            'countryId' => $countryId,
            'countries' => Country::query()->whereIn('id', $request->user()?->accessibleCountryIds() ?? [])->orderBy('name')->get(['id', 'name']),
            'claimSummary' => $dashboardService->claimSummary($countryId),
            'collectionSummary' => $dashboardService->countryCollectionSummary($countryId),
        ]);
    }

    public function priceTrends(Request $request): View
    {
        abort_unless($request->user()?->can('reports.view'), 403);

        $countryId = $this->resolveCountryId($request);
        $commodityId = $request->integer('commodity_id') ?: Commodity::query()->orderBy('code')->value('id');
        $days = max(7, min(365, $request->integer('days') ?: 30));

        $trends = collect();

        if ($commodityId) {
            $trends = CommodityPrice::query()
                ->selectRaw('price_date, AVG(price) as avg_price, COUNT(*) as count')
                ->where('commodity_id', $commodityId)
                ->where('price_date', '>=', now()->subDays($days)->toDateString())
                ->whereIn('market_id', Market::query()
                    ->when($countryId, fn ($q) => $q->where('country_id', $countryId))
                    ->select('id'))
                ->groupBy('price_date')
                ->orderBy('price_date')
                ->get();
        }

        return view('msl.reports.price-trends', [
            'trends' => $trends,
            'commodities' => Commodity::query()->with('translations')->orderBy('code')->get(),
            'commodityId' => $commodityId,
            'days' => $days,
            'countryId' => $countryId,
            'countries' => Country::query()->whereIn('id', $request->user()?->accessibleCountryIds() ?? [])->orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function exchangeRateTrends(Request $request): View
    {
        abort_unless($request->user()?->can('reports.view'), 403);

        $countryId = $this->resolveCountryId($request);
        $days = max(7, min(365, $request->integer('days') ?: 30));

        $trends = ExchangeRate::query()
            ->with(['baseCurrency', 'quoteCurrency'])
            ->when($countryId, fn ($q) => $q->where('country_id', $countryId))
            ->where('rate_date', '>=', now()->subDays($days)->toDateString())
            ->orderBy('rate_date')
            ->get()
            ->groupBy(fn ($r) => $r->baseCurrency?->code.'/'.$r->quoteCurrency?->code);

        return view('msl.reports.exchange-rate-trends', [
            'trends' => $trends,
            'days' => $days,
            'countryId' => $countryId,
            'countries' => Country::query()->whereIn('id', $request->user()?->accessibleCountryIds() ?? [])->orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function claims(Request $request): View
    {
        abort_unless($request->user()?->can('reports.view'), 403);

        $countryId = $this->resolveCountryId($request);

        $byStatus = Claim::query()
            ->when($countryId, fn ($q) => $q->where('country_id', $countryId))
            ->get(['status'])
            ->groupBy(fn ($c) => $c->status instanceof ClaimStatus ? $c->status->value : (string) $c->status)
            ->map->count();

        $byCountry = Claim::query()
            ->with('country')
            ->when($countryId, fn ($q) => $q->where('country_id', $countryId))
            ->get()
            ->groupBy(fn ($c) => $c->country?->name ?? '-')
            ->map->count();

        return view('msl.reports.claims', [
            'byStatus' => $byStatus,
            'byCountry' => $byCountry,
            'countryId' => $countryId,
            'countries' => Country::query()->whereIn('id', $request->user()?->accessibleCountryIds() ?? [])->orderBy('name')->get(['id', 'name']),
        ]);
    }
}
