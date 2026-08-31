<?php

namespace App\Http\Controllers;

use App\Concerns\ResolvesCountryFilter;
use App\Http\Requests\StoreExchangeRateRequest;
use App\Models\Country;
use App\Models\Currency;
use App\Models\ExchangeRate;
use App\Services\ExchangeRateService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExchangeRateController extends Controller
{
    use ResolvesCountryFilter;

    public function index(Request $request): View
    {
        abort_unless($request->user()?->can('exchange_rates.view'), 403);

        $countryId = $this->resolveCountryId($request);
        $rateDate = $this->resolveDateFilter($request, 'rate_date', defaultToToday: true);

        $exchangeRates = ExchangeRate::query()
            ->with(['country', 'baseCurrency', 'quoteCurrency', 'creator'])
            ->when($countryId, fn ($query) => $query->where('country_id', $countryId))
            ->when(! $request->user()?->isSuperAdmin(), function ($query) use ($request): void {
                $query->whereIn('country_id', $request->user()?->accessibleCountryIds() ?? []);
            })
            ->when($rateDate, fn ($query) => $query->whereDate('rate_date', $rateDate))
            ->latest('rate_date')
            ->paginate(15)
            ->withQueryString();

        $countries = Country::query()
            ->whereIn('id', $request->user()?->accessibleCountryIds() ?? [])
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('msl.exchange-rates.index', compact('exchangeRates', 'countries', 'countryId', 'rateDate'));
    }

    public function create(Request $request): View
    {
        abort_unless($request->user()?->can('exchange_rates.create'), 403);

        $countries = Country::query()
            ->whereIn('id', $request->user()?->accessibleCountryIds() ?? [])
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        $currencies = Currency::query()
            ->where('is_active', true)
            ->orderBy('code')
            ->get(['id', 'code', 'name']);

        $countryId = $this->resolveCountryId($request);

        return view('msl.exchange-rates.create', compact('countries', 'currencies', 'countryId'));
    }

    public function store(StoreExchangeRateRequest $request, ExchangeRateService $exchangeRateService): RedirectResponse
    {
        abort_unless($request->user()?->can('exchange_rates.create'), 403);

        $exchangeRateService->store($request->validated(), $request->user());

        return redirect()
            ->route('msl.exchange-rates.index')
            ->with('success', __('Taux de change enregistré avec succès.'));
    }

    public function edit(ExchangeRate $exchangeRate): View
    {
        abort_unless(auth()->user()?->can('exchange_rates.update') && auth()->user()?->hasCountryAccess($exchangeRate->country_id), 403);

        $countries = Country::query()
            ->whereIn('id', auth()->user()?->accessibleCountryIds() ?? [])
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        $currencies = Currency::query()
            ->where('is_active', true)
            ->orderBy('code')
            ->get(['id', 'code', 'name']);

        return view('msl.exchange-rates.edit', compact('exchangeRate', 'countries', 'currencies'));
    }

    public function update(Request $request, ExchangeRate $exchangeRate): RedirectResponse
    {
        abort_unless($request->user()?->can('exchange_rates.update') && $request->user()?->hasCountryAccess($exchangeRate->country_id), 403);

        $validated = $request->validate([
            'country_id' => ['required', 'integer', 'exists:countries,id'],
            'base_currency_id' => ['required', 'integer', 'exists:currencies,id'],
            'quote_currency_id' => ['required', 'integer', 'exists:currencies,id', 'different:base_currency_id'],
            'rate' => ['required', 'numeric', 'min:0'],
            'rate_date' => ['required', 'date'],
            'source' => ['nullable', 'string', 'max:255'],
        ]);

        abort_unless($request->user()?->hasCountryAccess((int) $validated['country_id']), 403);

        $exchangeRate->update($validated);

        return redirect()
            ->route('msl.exchange-rates.index')
            ->with('success', __('Taux de change mis à jour avec succès.'));
    }

    public function destroy(ExchangeRate $exchangeRate): RedirectResponse
    {
        abort_unless(auth()->user()?->can('exchange_rates.update') && auth()->user()?->hasCountryAccess($exchangeRate->country_id), 403);

        $exchangeRate->delete();

        return redirect()
            ->route('msl.exchange-rates.index')
            ->with('success', __('Taux de change supprimé avec succès.'));
    }
}
