<?php

namespace App\Http\Controllers;

use App\Concerns\ResolvesCountryFilter;
use App\Http\Requests\StoreCommodityPriceRequest;
use App\Models\Commodity;
use App\Models\CommodityPrice;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Market;
use App\Services\CommodityPriceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CommodityPriceController extends Controller
{
    use ResolvesCountryFilter;

    public function index(Request $request): View
    {
        $this->authorize('viewAny', CommodityPrice::class);

        $countryId = $this->resolveCountryId($request);
        $priceDate = $this->resolveDateFilter($request, 'price_date', defaultToToday: true);

        $prices = CommodityPrice::query()
            ->with(['commodity.translations', 'market.country', 'currency', 'creator'])
            ->when($countryId, fn ($query) => $query->whereHas('market', fn ($q) => $q->where('country_id', $countryId)))
            ->when($priceDate, fn ($query) => $query->whereDate('price_date', $priceDate))
            ->when(! $request->user()?->isSuperAdmin(), function ($query) use ($request): void {
                $query->whereHas('market', fn ($q) => $q->whereIn('country_id', $request->user()?->accessibleCountryIds() ?? []));
            })
            ->latest('price_date')
            ->paginate(15)
            ->withQueryString();

        $countries = Country::query()
            ->whereIn('id', $request->user()?->accessibleCountryIds() ?? [])
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('pahewo.commodity-prices.index', compact('prices', 'countries', 'countryId', 'priceDate'));
    }

    public function create(Request $request): View
    {
        $this->authorize('create', CommodityPrice::class);

        $countryId = $this->resolveCountryId($request);

        $markets = Market::query()
            ->when($countryId, fn ($query) => $query->where('country_id', $countryId))
            ->whereIn('country_id', $request->user()?->accessibleCountryIds() ?? [])
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'country_id']);

        $commodities = Commodity::query()
            ->with('translations')
            ->where('is_active', true)
            ->orderBy('code')
            ->get();

        $currencies = Currency::query()
            ->where('is_active', true)
            ->orderBy('code')
            ->get(['id', 'code', 'name']);

        $countries = Country::query()
            ->whereIn('id', $request->user()?->accessibleCountryIds() ?? [])
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('pahewo.commodity-prices.create', compact('markets', 'commodities', 'currencies', 'countries', 'countryId'));
    }

    public function store(StoreCommodityPriceRequest $request, CommodityPriceService $commodityPriceService): RedirectResponse
    {
        $this->authorize('create', CommodityPrice::class);

        $commodityPriceService->store($request->validated(), $request->user());

        return redirect()
            ->route('pahewo.commodity-prices.index')
            ->with('success', __('Prix enregistré avec succès.'));
    }

    public function edit(CommodityPrice $commodityPrice): View
    {
        $this->authorize('update', $commodityPrice);

        $markets = Market::query()
            ->whereIn('country_id', auth()->user()?->accessibleCountryIds() ?? [])
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'country_id']);

        $commodities = Commodity::query()
            ->with('translations')
            ->where('is_active', true)
            ->orderBy('code')
            ->get();

        $currencies = Currency::query()
            ->where('is_active', true)
            ->orderBy('code')
            ->get(['id', 'code', 'name']);

        return view('pahewo.commodity-prices.edit', compact('commodityPrice', 'markets', 'commodities', 'currencies'));
    }

    public function update(Request $request, CommodityPrice $commodityPrice): RedirectResponse
    {
        $this->authorize('update', $commodityPrice);

        $validated = $request->validate([
            'commodity_id' => ['required', 'integer', 'exists:commodities,id'],
            'market_id' => ['required', 'integer', 'exists:markets,id'],
            'currency_id' => ['required', 'integer', 'exists:currencies,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'price_date' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $market = Market::query()->findOrFail($validated['market_id']);
        abort_unless($request->user()?->hasCountryAccess($market->country_id), 403);

        $commodityPrice->update($validated);

        return redirect()
            ->route('pahewo.commodity-prices.index')
            ->with('success', __('Prix mis à jour avec succès.'));
    }

    public function destroy(CommodityPrice $commodityPrice): RedirectResponse
    {
        $this->authorize('delete', $commodityPrice);

        $commodityPrice->delete();

        return redirect()
            ->route('pahewo.commodity-prices.index')
            ->with('success', __('Prix supprimé avec succès.'));
    }
}
