<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClaimTypeTranslation extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'claim_type_id',
        'language_id',
        'name',
        'description',
    ];

    public function claimType(): BelongsTo
    {
        return $this->belongsTo(ClaimType::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
