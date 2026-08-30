<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ForexBureau extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'country_id',
        'name',
        'city',
        'address',
        'phone',
        'latitude',
        'longitude',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'is_active' => 'boolean',
        ];
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function forexRates(): HasMany
    {
        return $this->hasMany(ForexRate::class);
    }
}
