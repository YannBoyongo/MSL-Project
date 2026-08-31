<?php

namespace App\Http\Controllers;

use App\Concerns\ResolvesCountryFilter;
use App\Models\Commodity;
use App\Models\CommodityPrice;
use App\Models\Country;
use App\Models\Market;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PriceCompareController extends Controller
{
    use ResolvesCountryFilter;

    public function index(Request $request): View
    {
        abort_unless($request->user()?->can('prices.view'), 403);

        $countryId = $this->resolveCountryId($request);
        $commodityId = $request->integer('commodity_id') ?: null;
        $date = $request->input('date', today()->toDateString());

        $commodities = Commodity::query()->with('translations')->where('is_active', true)->orderBy('code')->get();
        $countries = Country::query()
            ->whereIn('id', $request->user()?->accessibleCountryIds() ?? [])
            ->orderBy('name')
            ->get(['id', 'name']);

        $prices = collect();

        if ($commodityId) {
            $prices = CommodityPrice::query()
                ->with(['commodity.translations', 'market.country', 'currency'])
                ->where('commodity_id', $commodityId)
                ->whereDate('price_date', $date)
                ->whereIn('market_id', Market::query()
                    ->when($countryId, fn ($q) => $q->where('country_id', $countryId))
                    ->when(! $request->user()?->isSuperAdmin(), fn ($q) => $q->whereIn('country_id', $request->user()?->accessibleCountryIds() ?? []))
                    ->select('id'))
                ->orderBy('price')
                ->get();
        }

        return view('msl.prices.compare', compact(
            'commodities', 'countries', 'countryId', 'commodityId', 'date', 'prices'
        ));
    }
}
