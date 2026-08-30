<?php

namespace App\Models;

use App\Enums\ClaimStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Claim extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'reference_number',
        'user_id',
        'country_id',
        'border_crossing_id',
        'market_id',
        'claim_type_id',
        'title',
        'description',
        'status',
        'occurred_at',
        'submitted_at',
        'resolved_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => ClaimStatus::class,
            'occurred_at' => 'datetime',
            'submitted_at' => 'datetime',
            'resolved_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function borderCrossing(): BelongsTo
    {
        return $this->belongsTo(BorderCrossing::class);
    }

    public function market(): BelongsTo
    {
        return $this->belongsTo(Market::class);
    }

    public function claimType(): BelongsTo
    {
        return $this->belongsTo(ClaimType::class);
    }

    public function statusHistories(): HasMany
    {
        return $this->hasMany(ClaimStatusHistory::class);
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(ClaimAttachment::class);
    }
}
