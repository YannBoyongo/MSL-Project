<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CurrencyController extends Controller
{
    public function index(): View
    {
        abort_unless(auth()->user()?->can('countries.manage'), 403);

        $currencies = Currency::query()->orderBy('code')->paginate(15);

        return view('msl.currencies.index', compact('currencies'));
    }

    public function create(): View
    {
        abort_unless(auth()->user()?->can('countries.manage'), 403);

        return view('msl.currencies.create');
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless($request->user()?->can('countries.manage'), 403);

        $validated = $request->validate([
            'code' => ['required', 'string', 'size:3', 'unique:currencies,code'],
            'name' => ['required', 'string', 'max:255'],
            'symbol' => ['nullable', 'string', 'max:10'],
            'decimal_places' => ['required', 'integer', 'min:0', 'max:4'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        Currency::query()->create($validated);

        return redirect()->route('msl.currencies.index')->with('success', __('Devise créée avec succès.'));
    }

    public function edit(Currency $currency): View
    {
        abort_unless(auth()->user()?->can('countries.manage'), 403);

        return view('msl.currencies.edit', compact('currency'));
    }

    public function update(Request $request, Currency $currency): RedirectResponse
    {
        abort_unless($request->user()?->can('countries.manage'), 403);

        $validated = $request->validate([
            'code' => ['required', 'string', 'size:3', 'unique:currencies,code,'.$currency->id],
            'name' => ['required', 'string', 'max:255'],
            'symbol' => ['nullable', 'string', 'max:10'],
            'decimal_places' => ['required', 'integer', 'min:0', 'max:4'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', false);

        $currency->update($validated);

        return redirect()->route('msl.currencies.index')->with('success', __('Devise mise à jour avec succès.'));
    }

    public function destroy(Request $request, Currency $currency): RedirectResponse
    {
        abort_unless($request->user()?->can('countries.manage'), 403);

        $currency->delete();

        return redirect()->route('msl.currencies.index')->with('success', __('Devise supprimée avec succès.'));
    }
}
