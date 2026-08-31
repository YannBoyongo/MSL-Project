<?php

namespace App\Http\Controllers;

use App\Concerns\ResolvesCountryFilter;
use App\Http\Requests\StoreMarketRequest;
use App\Models\Country;
use App\Models\Market;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MarketController extends Controller
{
    use ResolvesCountryFilter;

    public function index(Request $request): View
    {
        $this->authorize('viewAny', Market::class);

        $countryId = $this->resolveCountryId($request);

        $markets = Market::query()
            ->with('country')
            ->when($countryId, fn ($query) => $query->where('country_id', $countryId))
            ->when(! $request->user()?->isSuperAdmin(), function ($query) use ($request): void {
                $query->whereIn('country_id', $request->user()?->accessibleCountryIds() ?? []);
            })
            ->when($request->filled('search'), fn ($query) => $query->where('name', 'like', '%'.$request->string('search').'%'))
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        $countries = Country::query()
            ->whereIn('id', $request->user()?->accessibleCountryIds() ?? [])
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('msl.markets.index', compact('markets', 'countries', 'countryId'));
    }

    public function create(Request $request): View
    {
        $this->authorize('create', Market::class);

        $countries = Country::query()
            ->whereIn('id', $request->user()?->accessibleCountryIds() ?? [])
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('msl.markets.create', compact('countries'));
    }

    public function store(StoreMarketRequest $request): RedirectResponse
    {
        $this->authorize('create', Market::class);

        $validated = $request->validated();
        $validated['is_active'] = $request->boolean('is_active', true);

        Market::query()->create($validated);

        return redirect()
            ->route('msl.markets.index')
            ->with('success', __('Marché créé avec succès.'));
    }

    public function edit(Market $market): View
    {
        $this->authorize('update', $market);

        $countries = Country::query()
            ->whereIn('id', auth()->user()?->accessibleCountryIds() ?? [])
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('msl.markets.edit', compact('market', 'countries'));
    }

    public function update(Request $request, Market $market): RedirectResponse
    {
        $this->authorize('update', $market);

        $validated = $request->validate([
            'country_id' => ['required', 'integer', 'exists:countries,id'],
            'name' => ['required', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:500'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        abort_unless($request->user()?->hasCountryAccess((int) $validated['country_id']), 403);

        $validated['is_active'] = $request->boolean('is_active', false);

        $market->update($validated);

        return redirect()
            ->route('msl.markets.index')
            ->with('success', __('Marché mis à jour avec succès.'));
    }

    public function destroy(Market $market): RedirectResponse
    {
        $this->authorize('delete', $market);

        $market->delete();

        return redirect()
            ->route('msl.markets.index')
            ->with('success', __('Marché supprimé avec succès.'));
    }
}
