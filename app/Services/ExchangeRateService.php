<?php

namespace App\Services;

use App\Models\ExchangeRate;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class ExchangeRateService
{
    /**
     * @param  array{
     *     country_id: int,
     *     base_currency_id: int,
     *     quote_currency_id: int,
     *     rate: float|string,
     *     rate_date: \DateTimeInterface|string,
     *     source?: string|null
     * }  $data
     */
    public function store(array $data, User $creator): ExchangeRate
    {
        return DB::transaction(function () use ($data, $creator): ExchangeRate {
            $rate = new ExchangeRate;
            $rate->country_id = $data['country_id'];
            $rate->base_currency_id = $data['base_currency_id'];
            $rate->quote_currency_id = $data['quote_currency_id'];
            $rate->rate = $data['rate'];
            $rate->rate_date = date('Y-m-d', strtotime((string) $data['rate_date']));
            $rate->source = $data['source'] ?? null;
            $rate->created_by = $creator->id;
            $rate->save();

            return $rate->fresh();
        });
    }

    public function findOrFail(int $exchangeRateId): ExchangeRate
    {
        $rate = ExchangeRate::query()->find($exchangeRateId);

        if ($rate === null) {
            throw (new ModelNotFoundException)->setModel(ExchangeRate::class, [$exchangeRateId]);
        }

        return $rate;
    }
}
