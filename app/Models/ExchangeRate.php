<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExchangeRate extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'country_id',
        'base_currency_id',
        'quote_currency_id',
        'rate',
        'rate_date',
        'source',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'rate' => 'decimal:6',
            'rate_date' => 'date',
        ];
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
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
