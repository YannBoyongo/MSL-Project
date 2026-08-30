<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreExchangeRateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();

        return $user !== null
            && $user->can('exchange_rates.create')
            && $user->hasCountryAccess((int) $this->input('country_id'));
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'country_id' => ['required', 'integer', 'exists:countries,id'],
            'base_currency_id' => ['required', 'integer', 'exists:currencies,id'],
            'quote_currency_id' => ['required', 'integer', 'exists:currencies,id', 'different:base_currency_id'],
            'rate' => ['required', 'numeric', 'min:0'],
            'rate_date' => ['required', 'date'],
            'source' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'country_id' => 'pays',
            'base_currency_id' => 'devise de base',
            'quote_currency_id' => 'devise de destination',
            'rate' => 'taux',
            'rate_date' => 'date du taux',
            'source' => 'source',
        ];
    }
}
