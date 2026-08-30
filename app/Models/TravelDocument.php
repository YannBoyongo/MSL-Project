<?php

namespace App\Models;

use App\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TravelDocument extends Model
{
    use HasTranslations;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'country_id',
        'document_type_id',
        'is_required',
        'validity_days',
        'fee',
        'fee_currency_id',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_required' => 'boolean',
            'validity_days' => 'integer',
            'fee' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    protected function translationNameAttribute(): string
    {
        return 'title';
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function documentType(): BelongsTo
    {
        return $this->belongsTo(DocumentType::class);
    }

    public function feeCurrency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'fee_currency_id');
    }

    public function translations(): HasMany
    {
        return $this->hasMany(TravelDocumentTranslation::class);
    }
}
