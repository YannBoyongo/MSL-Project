<?php

namespace App\Services;

use App\Enums\ClaimStatus;
use App\Models\Claim;
use App\Models\ClaimStatusHistory;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class ClaimService
{
    /**
     * @param  array{
     *     user_id: int,
     *     country_id: int,
     *     claim_type_id: int,
     *     title: string,
     *     description: string,
     *     border_crossing_id?: int|null,
     *     market_id?: int|null,
     *     occurred_at?: \DateTimeInterface|string|null,
     *     comment?: string|null
     * }  $data
     */
    public function createClaim(array $data, User $creator): Claim
    {
        return DB::transaction(function () use ($data, $creator): Claim {
            $claim = new Claim;
            $claim->reference_number = $this->generateReferenceNumber();
            $claim->user_id = $data['user_id'];
            $claim->country_id = $data['country_id'];
            $claim->border_crossing_id = $data['border_crossing_id'] ?? null;
            $claim->market_id = $data['market_id'] ?? null;
            $claim->claim_type_id = $data['claim_type_id'];
            $claim->title = $data['title'];
            $claim->description = $data['description'];
            $claim->status = ClaimStatus::Submitted->value;
            $claim->occurred_at = $data['occurred_at'] ?? null;
            $claim->submitted_at = now();
            $claim->save();

            $history = new ClaimStatusHistory;
            $history->claim_id = $claim->id;
            $history->status = ClaimStatus::Submitted->value;
            $history->comment = $data['comment'] ?? __('Claim submitted.');
            $history->changed_by = $creator->id;
            $history->save();

            return $claim->fresh();
        });
    }

    public function generateReferenceNumber(?int $year = null): string
    {
        $year ??= (int) now()->format('Y');
        $prefix = sprintf('CLM-%d-', $year);

        $latestReference = Claim::query()
            ->where('reference_number', 'like', $prefix.'%')
            ->orderByDesc('reference_number')
            ->value('reference_number');

        $nextSequence = 1;

        if (is_string($latestReference)) {
            $sequence = (int) substr($latestReference, -6);

            if ($sequence <= 0) {
                throw new InvalidArgumentException('Unable to determine the next claim reference number.');
            }

            $nextSequence = $sequence + 1;
        }

        return sprintf('%s%06d', $prefix, $nextSequence);
    }
}
