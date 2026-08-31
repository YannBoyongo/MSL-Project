<?php

namespace App\Http\Controllers;

use App\Concerns\ResolvesCountryFilter;
use App\Models\Country;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CountryController extends Controller
{
    use ResolvesCountryFilter;

    public function index(Request $request): View
    {
        abort_unless($request->user()?->can('countries.view'), 403);

        $countries = Country::query()
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('msl.countries.index', compact('countries'));
    }

    public function create(Request $request): View
    {
        abort_unless($request->user()?->can('countries.manage'), 403);

        return view('msl.countries.create');
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless($request->user()?->can('countries.manage'), 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'iso_code' => ['required', 'string', 'size:2', 'unique:countries,iso_code'],
            'phone_code' => ['nullable', 'string', 'max:10'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        Country::query()->create($validated);

        return redirect()
            ->route('msl.countries.index')
            ->with('success', __('Pays créé avec succès.'));
    }

    public function edit(Request $request, Country $country): View
    {
        abort_unless($request->user()?->can('countries.manage'), 403);

        return view('msl.countries.edit', compact('country'));
    }

    public function update(Request $request, Country $country): RedirectResponse
    {
        abort_unless($request->user()?->can('countries.manage'), 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'iso_code' => ['required', 'string', 'size:2', 'unique:countries,iso_code,'.$country->id],
            'phone_code' => ['nullable', 'string', 'max:10'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', false);

        $country->update($validated);

        return redirect()
            ->route('msl.countries.index')
            ->with('success', __('Pays mis à jour avec succès.'));
    }

    public function destroy(Request $request, Country $country): RedirectResponse
    {
        abort_unless($request->user()?->can('countries.manage'), 403);

        $country->delete();

        return redirect()
            ->route('msl.countries.index')
            ->with('success', __('Pays supprimé avec succès.'));
    }
}
