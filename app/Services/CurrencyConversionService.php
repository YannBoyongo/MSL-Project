<?php

namespace App\Services;

use App\Models\ExchangeRate;
use Illuminate\Database\Eloquent\Builder;
use RuntimeException;

class CurrencyConversionService
{
    public function convert(
        float $amount,
        int $fromCurrencyId,
        int $toCurrencyId,
        ?int $countryId = null,
        ?string $asOfDate = null,
    ): float {
        if ($fromCurrencyId === $toCurrencyId) {
            return $amount;
        }

        $rate = $this->findLatestRate($fromCurrencyId, $toCurrencyId, $countryId, $asOfDate);

        if ($rate !== null) {
            return round($amount * (float) $rate->rate, 4);
        }

        $inverseRate = $this->findLatestRate($toCurrencyId, $fromCurrencyId, $countryId, $asOfDate);

        if ($inverseRate !== null && (float) $inverseRate->rate !== 0.0) {
            return round($amount / (float) $inverseRate->rate, 4);
        }

        throw new RuntimeException(__('No exchange rate is available for the requested currency conversion.'));
    }

    public function findLatestRate(
        int $baseCurrencyId,
        int $quoteCurrencyId,
        ?int $countryId = null,
        ?string $asOfDate = null,
    ): ?ExchangeRate {
        return ExchangeRate::query()
            ->where('base_currency_id', $baseCurrencyId)
            ->where('quote_currency_id', $quoteCurrencyId)
            ->when($countryId, fn (Builder $query) => $query->where('country_id', $countryId))
            ->when($asOfDate, fn (Builder $query) => $query->whereDate('rate_date', '<=', $asOfDate))
            ->orderByDesc('rate_date')
            ->orderByDesc('id')
            ->first();
    }
}
