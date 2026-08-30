<?php

namespace App\Policies;

use App\Models\Claim;
use App\Models\User;

class ClaimPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('claims.view');
    }

    public function view(User $user, Claim $claim): bool
    {
        if (! $user->can('claims.view')) {
            return false;
        }

        if ($user->can('claims.review')) {
            return $user->hasCountryAccess($claim->country_id);
        }

        return $claim->user_id === $user->id && $user->hasCountryAccess($claim->country_id);
    }

    public function create(User $user): bool
    {
        return $user->can('claims.create');
    }

    public function update(User $user, Claim $claim): bool
    {
        return $user->can('claims.review') && $user->hasCountryAccess($claim->country_id);
    }

    public function delete(User $user, Claim $claim): bool
    {
        return $user->can('claims.resolve') && $user->hasCountryAccess($claim->country_id);
    }
}
