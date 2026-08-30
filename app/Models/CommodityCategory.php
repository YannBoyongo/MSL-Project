<?php

namespace App\Models;

use App\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CommodityCategory extends Model
{
    use HasTranslations;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'code',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function translations(): HasMany
    {
        return $this->hasMany(CommodityCategoryTranslation::class);
    }

    public function commodities(): HasMany
    {
        return $this->hasMany(Commodity::class);
    }
}
