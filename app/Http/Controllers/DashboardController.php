<?php

namespace App\Http\Controllers;

use App\Concerns\ResolvesCountryFilter;
use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    use ResolvesCountryFilter;

    public function index(Request $request, DashboardService $dashboardService): View
    {
        $countryId = $this->resolveCountryId($request);

        $data = [
            'countryId' => $countryId,
            'todayPriceCount' => $dashboardService->todayPriceCount($countryId),
            'todayExchangeRateCount' => $dashboardService->todayExchangeRateCount($countryId),
            'priceCollectionCompletion' => $dashboardService->priceCollectionCompletion($countryId),
            'countryCollectionSummary' => $dashboardService->countryCollectionSummary($countryId),
            'latestExchangeRates' => $dashboardService->latestExchangeRates($countryId),
            'claimSummary' => $dashboardService->claimSummary($countryId),
            'recentActivity' => $dashboardService->recentActivity($countryId),
        ];

        $user = $request->user();

        if ($user?->hasRole('trader')) {
            return view('pahewo.dashboard.trader', $data);
        }

        if ($user?->hasAnyRole(['data-collector', 'market-officer'])) {
            return view('pahewo.dashboard.collector', $data);
        }

        return view('pahewo.dashboard.admin', $data);
    }
}
