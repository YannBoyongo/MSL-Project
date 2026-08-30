<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ForexRate extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'forex_bureau_id',
        'base_currency_id',
        'quote_currency_id',
        'buy_rate',
        'sell_rate',
        'rate_date',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'buy_rate' => 'decimal:6',
            'sell_rate' => 'decimal:6',
            'rate_date' => 'date',
        ];
    }

    public function forexBureau(): BelongsTo
    {
        return $this->belongsTo(ForexBureau::class);
    }

    public function baseCurrency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'base_currency_id');
    }

    public function quoteCurrency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'quote_currency_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
