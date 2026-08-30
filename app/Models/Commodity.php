<?php

namespace App\Models;

use App\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Commodity extends Model
{
    use HasTranslations;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'commodity_category_id',
        'measurement_unit_id',
        'code',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(CommodityCategory::class, 'commodity_category_id');
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(MeasurementUnit::class, 'measurement_unit_id');
    }

    public function translations(): HasMany
    {
        return $this->hasMany(CommodityTranslation::class);
    }

    public function prices(): HasMany
    {
        return $this->hasMany(CommodityPrice::class);
    }
}
