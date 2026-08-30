<?php

namespace App\Concerns;

use Illuminate\Http\Request;

trait ResolvesCountryFilter
{
    protected function resolveCountryId(Request $request): ?int
    {
        if ($request->has('country_id')) {
            $value = $request->input('country_id');

            if ($value === '' || $value === null) {
                $request->session()->forget('country_id');

                return null;
            }

            $countryId = (int) $value;
            $request->session()->put('country_id', $countryId);

            return $countryId;
        }

        $sessionCountryId = $request->session()->get('country_id');

        if ($sessionCountryId !== null) {
            return (int) $sessionCountryId;
        }

        $accessibleCountryIds = $request->user()?->accessibleCountryIds() ?? [];

        if (count($accessibleCountryIds) === 1) {
            return $accessibleCountryIds[0];
        }

        return null;
    }

    protected function resolveDateFilter(Request $request, string $key, bool $defaultToToday = false): ?string
    {
        if ($request->has($key)) {
            $value = $request->input($key);

            if ($value === '' || $value === null) {
                $request->session()->forget("filter.{$key}");

                return null;
            }

            $date = $request->date($key)->toDateString();
            $request->session()->put("filter.{$key}", $date);

            return $date;
        }

        $sessionDate = $request->session()->get("filter.{$key}");

        if ($sessionDate !== null) {
            return $sessionDate === '' ? null : (string) $sessionDate;
        }

        if ($defaultToToday) {
            return today()->toDateString();
        }

        return null;
    }
}
