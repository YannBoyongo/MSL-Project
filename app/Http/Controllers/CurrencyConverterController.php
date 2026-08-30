<?php

namespace App\Http\Controllers;

use App\Concerns\ResolvesCountryFilter;
use App\Models\Country;
use App\Models\Currency;
use App\Services\CurrencyConversionService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RuntimeException;

class CurrencyConverterController extends Controller
{
    use ResolvesCountryFilter;

    public function index(Request $request, CurrencyConversionService $converter): View
    {
        abort_unless($request->user()?->can('exchange_rates.view'), 403);

        $countryId = $this->resolveCountryId($request);
        $currencies = Currency::query()->where('is_active', true)->orderBy('code')->get();
        $countries = Country::query()
            ->whereIn('id', $request->user()?->accessibleCountryIds() ?? [])
            ->orderBy('name')
            ->get(['id', 'name']);

        $result = null;
        $error = null;

        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'amount' => ['required', 'numeric', 'min:0'],
                'from_currency_id' => ['required', 'exists:currencies,id'],
                'to_currency_id' => ['required', 'exists:currencies,id', 'different:from_currency_id'],
            ]);

            try {
                $result = $converter->convert(
                    (float) $validated['amount'],
                    (int) $validated['from_currency_id'],
                    (int) $validated['to_currency_id'],
                    $countryId,
                );
            } catch (RuntimeException $exception) {
                $error = $exception->getMessage();
            }
        }

        return view('pahewo.tools.currency-converter', compact(
            'currencies', 'countries', 'countryId', 'result', 'error'
        ));
    }
}
