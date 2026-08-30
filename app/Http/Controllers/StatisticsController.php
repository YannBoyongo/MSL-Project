<?php

namespace App\Http\Controllers;

use App\Concerns\ResolvesCountryFilter;
use App\Models\Claim;
use App\Models\CommodityPrice;
use App\Models\Country;
use App\Models\ExchangeRate;
use App\Models\Market;
use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StatisticsController extends Controller
{
    use ResolvesCountryFilter;

    public function index(Request $request, DashboardService $dashboardService): View
    {
        abort_unless($request->user()?->can('reports.view'), 403);

        $countryId = $this->resolveCountryId($request);

        return view('pahewo.statistics.index', [
            'countryId' => $countryId,
            'marketCount' => Market::query()
                ->when($countryId, fn ($q) => $q->where('country_id', $countryId))
                ->when(! $request->user()?->isSuperAdmin(), fn ($q) => $q->whereIn('country_id', $request->user()?->accessibleCountryIds() ?? []))
                ->where('is_active', true)
                ->count(),
            'todayPriceCount' => $dashboardService->todayPriceCount($countryId),
            'todayExchangeRateCount' => $dashboardService->todayExchangeRateCount($countryId),
            'totalPrices' => CommodityPrice::query()
                ->when($countryId, fn ($q) => $q->whereIn('market_id', Market::query()->where('country_id', $countryId)->select('id')))
                ->count(),
            'totalRates' => ExchangeRate::query()
                ->when($countryId, fn ($q) => $q->where('country_id', $countryId))
                ->count(),
            'totalClaims' => Claim::query()
                ->when($countryId, fn ($q) => $q->where('country_id', $countryId))
                ->count(),
            'collectionSummary' => $dashboardService->countryCollectionSummary($countryId),
            'countries' => Country::query()
                ->whereIn('id', $request->user()?->accessibleCountryIds() ?? [])
                ->orderBy('name')
                ->get(['id', 'name']),
        ]);
    }
}
