<?php

namespace App\Http\Controllers;

use App\Concerns\ResolvesCountryFilter;
use App\Models\Country;
use App\Models\ForexBureau;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ForexBureauController extends Controller
{
    use ResolvesCountryFilter;

    public function index(Request $request): View
    {
        abort_unless($request->user()?->can('exchange_rates.view'), 403);

        $countryId = $this->resolveCountryId($request);

        $forexBureaus = ForexBureau::query()
            ->with('country')
            ->when($countryId, fn ($q) => $q->where('country_id', $countryId))
            ->when(! $request->user()?->isSuperAdmin(), fn ($q) => $q->whereIn('country_id', $request->user()?->accessibleCountryIds() ?? []))
            ->when($request->filled('search'), fn ($q) => $q->where('name', 'like', '%'.$request->string('search').'%'))
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        $countries = Country::query()
            ->whereIn('id', $request->user()?->accessibleCountryIds() ?? [])
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('pahewo.forex-bureaus.index', compact('forexBureaus', 'countries', 'countryId'));
    }

    public function create(Request $request): View
    {
        abort_unless($request->user()?->can('exchange_rates.create'), 403);

        $countries = Country::query()
            ->whereIn('id', $request->user()?->accessibleCountryIds() ?? [])
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('pahewo.forex-bureaus.create', compact('countries'));
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless($request->user()?->can('exchange_rates.create'), 403);
        abort_unless($request->user()?->hasCountryAccess((int) $request->input('country_id')), 403);

        $validated = $request->validate([
            'country_id' => ['required', 'exists:countries,id'],
            'name' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        ForexBureau::query()->create($validated);

        return redirect()->route('pahewo.forex-bureaus.index')->with('success', __('Bureau de change créé avec succès.'));
    }

    public function edit(ForexBureau $forexBureau): View
    {
        abort_unless(auth()->user()?->can('exchange_rates.update'), 403);
        abort_unless(auth()->user()?->hasCountryAccess($forexBureau->country_id), 403);

        $countries = Country::query()
            ->whereIn('id', auth()->user()?->accessibleCountryIds() ?? [])
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('pahewo.forex-bureaus.edit', compact('forexBureau', 'countries'));
    }

    public function update(Request $request, ForexBureau $forexBureau): RedirectResponse
    {
        abort_unless($request->user()?->can('exchange_rates.update'), 403);
        abort_unless($request->user()?->hasCountryAccess($forexBureau->country_id), 403);
        abort_unless($request->user()?->hasCountryAccess((int) $request->input('country_id')), 403);

        $validated = $request->validate([
            'country_id' => ['required', 'exists:countries,id'],
            'name' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', false);

        $forexBureau->update($validated);

        return redirect()->route('pahewo.forex-bureaus.index')->with('success', __('Bureau de change mis à jour avec succès.'));
    }

    public function destroy(Request $request, ForexBureau $forexBureau): RedirectResponse
    {
        abort_unless($request->user()?->can('exchange_rates.update'), 403);
        abort_unless($request->user()?->hasCountryAccess($forexBureau->country_id), 403);

        $forexBureau->delete();

        return redirect()->route('pahewo.forex-bureaus.index')->with('success', __('Bureau de change supprimé avec succès.'));
    }
}
