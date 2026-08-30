<?php

namespace App\Http\Middleware;

use App\Models\Country;
use App\Models\Market;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCountryAccess
{
    /**
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user === null) {
            abort(401);
        }

        $countryId = $this->resolveCountryId($request);

        if ($countryId !== null && ! $user->hasCountryAccess($countryId)) {
            abort(403, __('Accès refusé pour ce pays.'));
        }

        return $next($request);
    }

    private function resolveCountryId(Request $request): ?int
    {
        if ($request->route('country') instanceof Country) {
            return $request->route('country')->id;
        }

        if ($request->route('market') instanceof Market) {
            return $request->route('market')->country_id;
        }

        foreach (['country_id', 'country'] as $key) {
            $value = $request->route($key) ?? $request->input($key);

            if ($value !== null && $value !== '') {
                return (int) $value;
            }
        }

        return null;
    }
}
