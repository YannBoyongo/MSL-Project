<?php

namespace App\Enums;

enum BorderStatus: string
{
    case Open = 'open';
    case Restricted = 'restricted';
    case TemporarilyClosed = 'temporarily_closed';
    case Closed = 'closed';

    public function label(): string
    {
        return match ($this) {
            self::Open => __('Ouvert'),
            self::Restricted => __('Restreint'),
            self::TemporarilyClosed => __('Temporairement fermé'),
            self::Closed => __('Fermé'),
        };
    }
}
