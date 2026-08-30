<?php

namespace App\Models;

use App\Enums\ClaimStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClaimStatusHistory extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'claim_id',
        'status',
        'comment',
        'changed_by',
    ];

    protected function casts(): array
    {
        return [
            'status' => ClaimStatus::class,
        ];
    }

    public function claim(): BelongsTo
    {
        return $this->belongsTo(Claim::class);
    }

    public function changedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
