<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommodityCategoryTranslation extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'commodity_category_id',
        'language_id',
        'name',
        'description',
    ];

    public function commodityCategory(): BelongsTo
    {
        return $this->belongsTo(CommodityCategory::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
