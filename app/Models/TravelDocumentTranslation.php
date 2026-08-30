<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TravelDocumentTranslation extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'travel_document_id',
        'language_id',
        'title',
        'description',
        'requirements',
        'instructions',
    ];

    public function travelDocument(): BelongsTo
    {
        return $this->belongsTo(TravelDocument::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
