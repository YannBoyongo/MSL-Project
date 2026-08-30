<?php

namespace App\Models;

use App\Enums\BorderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BorderCrossing extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'country_a_id',
        'country_b_id',
        'latitude',
        'longitude',
        'opening_time',
        'closing_time',
        'status',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'status' => BorderStatus::class,
            'is_active' => 'boolean',
        ];
    }

    public function countryA(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_a_id');
    }

    public function countryB(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_b_id');
    }
}
