<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommodityPrice extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'commodity_id',
        'market_id',
        'currency_id',
        'price',
        'price_date',
        'created_by',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:4',
            'price_date' => 'date',
        ];
    }

    public function commodity(): BelongsTo
    {
        return $this->belongsTo(Commodity::class);
    }

    public function market(): BelongsTo
    {
        return $this->belongsTo(Market::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
