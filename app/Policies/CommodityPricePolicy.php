<?php

namespace App\Policies;

use App\Models\CommodityPrice;
use App\Models\User;

class CommodityPricePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('prices.view');
    }

    public function view(User $user, CommodityPrice $commodityPrice): bool
    {
        if (! $user->can('prices.view')) {
            return false;
        }

        $commodityPrice->loadMissing('market');

        return $commodityPrice->market !== null
            && $user->hasCountryAccess($commodityPrice->market->country_id);
    }

    public function create(User $user): bool
    {
        return $user->can('prices.create');
    }

    public function update(User $user, CommodityPrice $commodityPrice): bool
    {
        if (! $user->can('prices.update')) {
            return false;
        }

        $commodityPrice->loadMissing('market');

        return $commodityPrice->market !== null
            && $user->hasCountryAccess($commodityPrice->market->country_id);
    }

    public function delete(User $user, CommodityPrice $commodityPrice): bool
    {
        if (! $user->can('prices.delete')) {
            return false;
        }

        $commodityPrice->loadMissing('market');

        return $commodityPrice->market !== null
            && $user->hasCountryAccess($commodityPrice->market->country_id);
    }
}
