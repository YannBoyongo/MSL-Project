<?php

namespace App\Policies;

use App\Models\Market;
use App\Models\User;

class MarketPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('markets.view');
    }

    public function view(User $user, Market $market): bool
    {
        return $user->can('markets.view') && $user->hasCountryAccess($market->country_id);
    }

    public function create(User $user): bool
    {
        return $user->can('markets.create');
    }

    public function update(User $user, Market $market): bool
    {
        return $user->can('markets.update') && $user->hasCountryAccess($market->country_id);
    }

    public function delete(User $user, Market $market): bool
    {
        return $user->can('markets.delete') && $user->hasCountryAccess($market->country_id);
    }
}
