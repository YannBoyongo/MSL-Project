<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactPerson extends Model
{
    protected $table = 'contact_persons';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'country_id',
        'border_crossing_id',
        'market_id',
        'name',
        'organization',
        'position',
        'phone',
        'email',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
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
}
