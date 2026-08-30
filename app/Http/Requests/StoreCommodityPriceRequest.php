<?php

namespace App\Http\Requests;

use App\Models\Market;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCommodityPriceRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();

        if ($user === null || ! $user->can('prices.create')) {
            return false;
        }

        $market = Market::query()->find($this->input('market_id'));

        return $market !== null && $user->hasCountryAccess($market->country_id);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'commodity_id' => ['required', 'integer', 'exists:commodities,id'],
            'market_id' => ['required', 'integer', 'exists:markets,id'],
            'currency_id' => ['required', 'integer', 'exists:currencies,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'price_date' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'commodity_id' => 'marchandise',
            'market_id' => 'marché',
            'currency_id' => 'devise',
            'price' => 'prix',
            'price_date' => 'date du prix',
            'notes' => 'notes',
        ];
    }
}
