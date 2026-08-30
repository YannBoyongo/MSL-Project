<?php

namespace App\Enums;

enum ClaimStatus: string
{
    case Submitted = 'submitted';
    case UnderReview = 'under_review';
    case Pending = 'pending';
    case Resolved = 'resolved';
    case Rejected = 'rejected';
    case Closed = 'closed';

    public function label(): string
    {
        return match ($this) {
            self::Submitted => __('Soumise'),
            self::UnderReview => __('En cours d\'examen'),
            self::Pending => __('En attente'),
            self::Resolved => __('Résolue'),
            self::Rejected => __('Rejetée'),
            self::Closed => __('Fermée'),
        };
    }
}
