<?php

namespace App\Services;

use App\Models\CommodityPrice;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CommodityPriceService
{
    /**
     * @param  array{
     *     commodity_id: int,
     *     market_id: int,
     *     currency_id: int,
     *     price: float|string,
     *     price_date: \DateTimeInterface|string,
     *     notes?: string|null
     * }  $data
     */
    public function store(array $data, User $creator): CommodityPrice
    {
        $priceDate = date('Y-m-d', strtotime((string) $data['price_date']));

        $duplicateExists = CommodityPrice::query()
            ->where('commodity_id', $data['commodity_id'])
            ->where('market_id', $data['market_id'])
            ->where('currency_id', $data['currency_id'])
            ->whereDate('price_date', $priceDate)
            ->exists();

        if ($duplicateExists) {
            throw ValidationException::withMessages([
                'price_date' => __('A price already exists for this commodity, market, currency, and date.'),
            ]);
        }

        return DB::transaction(function () use ($data, $creator, $priceDate): CommodityPrice {
            $price = new CommodityPrice;
            $price->commodity_id = $data['commodity_id'];
            $price->market_id = $data['market_id'];
            $price->currency_id = $data['currency_id'];
            $price->price = $data['price'];
            $price->price_date = $priceDate;
            $price->created_by = $creator->id;
            $price->notes = $data['notes'] ?? null;
            $price->save();

            return $price->fresh();
        });
    }

    public function findOrFail(int $commodityPriceId): CommodityPrice
    {
        $price = CommodityPrice::query()->find($commodityPriceId);

        if ($price === null) {
            throw (new ModelNotFoundException)->setModel(CommodityPrice::class, [$commodityPriceId]);
        }

        return $price;
    }
}
