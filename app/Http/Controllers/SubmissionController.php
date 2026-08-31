<?php

namespace App\Http\Controllers;

use App\Models\CommodityPrice;
use App\Models\ExchangeRate;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubmissionController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless($request->user()?->can('prices.view'), 403);

        $userId = $request->user()->id;

        $recentPrices = CommodityPrice::query()
            ->with(['commodity.translations', 'market', 'currency'])
            ->where('created_by', $userId)
            ->whereDate('price_date', today())
            ->latest()
            ->limit(20)
            ->get();

        $recentRates = ExchangeRate::query()
            ->with(['baseCurrency', 'quoteCurrency', 'country'])
            ->where('created_by', $userId)
            ->whereDate('rate_date', today())
            ->latest()
            ->limit(20)
            ->get();

        return view('msl.submissions.index', compact('recentPrices', 'recentRates'));
    }

    public function history(Request $request): View
    {
        abort_unless($request->user()?->can('prices.view'), 403);

        $userId = $request->user()->id;

        $prices = CommodityPrice::query()
            ->with(['commodity.translations', 'market', 'currency'])
            ->where('created_by', $userId)
            ->latest()
            ->paginate(15, ['*'], 'prices_page');

        $rates = ExchangeRate::query()
            ->with(['baseCurrency', 'quoteCurrency', 'country'])
            ->where('created_by', $userId)
            ->latest()
            ->paginate(15, ['*'], 'rates_page');

        return view('msl.submissions.history', compact('prices', 'rates'));
    }
}
