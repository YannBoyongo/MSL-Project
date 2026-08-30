<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreClaimRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();

        return $user !== null
            && $user->can('claims.create')
            && $user->hasCountryAccess((int) $this->input('country_id'));
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'country_id' => ['required', 'integer', 'exists:countries,id'],
            'claim_type_id' => ['required', 'integer', 'exists:claim_types,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'border_crossing_id' => ['nullable', 'integer', 'exists:border_crossings,id'],
            'market_id' => ['nullable', 'integer', 'exists:markets,id'],
            'occurred_at' => ['nullable', 'date'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'country_id' => 'pays',
            'claim_type_id' => 'type de réclamation',
            'title' => 'titre',
            'description' => 'description',
            'border_crossing_id' => 'poste frontalier',
            'market_id' => 'marché',
            'occurred_at' => 'date de l\'incident',
        ];
    }
}
