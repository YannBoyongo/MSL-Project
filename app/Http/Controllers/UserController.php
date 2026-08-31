<?php

namespace App\Http\Controllers;

use App\Concerns\ResolvesCountryFilter;
use App\Models\Country;
use App\Models\Language;
use App\Models\Market;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    use ResolvesCountryFilter;

    public function index(Request $request): View
    {
        abort_unless($request->user()?->can('users.view'), 403);

        $countryId = $this->resolveCountryId($request);

        $users = User::query()
            ->with(['countries', 'roles'])
            ->when($countryId, fn ($query) => $query->whereHas('countries', fn ($q) => $q->where('countries.id', $countryId)))
            ->when($request->filled('search'), fn ($query) => $query->where(function ($q) use ($request): void {
                $q->where('name', 'like', '%'.$request->string('search').'%')
                    ->orWhere('email', 'like', '%'.$request->string('search').'%');
            }))
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        $countries = Country::query()
            ->whereIn('id', $request->user()?->accessibleCountryIds() ?? [])
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('msl.users.index', compact('users', 'countries', 'countryId'));
    }

    public function create(Request $request): View
    {
        abort_unless($request->user()?->can('users.manage'), 403);

        $countries = Country::query()
            ->whereIn('id', $request->user()?->accessibleCountryIds() ?? [])
            ->orderBy('name')
            ->get(['id', 'name']);

        $markets = Market::query()
            ->whereIn('country_id', $request->user()?->accessibleCountryIds() ?? [])
            ->orderBy('name')
            ->get(['id', 'name', 'country_id']);

        $roles = Role::query()->orderBy('name')->get(['id', 'name']);
        $languages = Language::query()->where('is_active', true)->orderBy('name')->get(['id', 'name']);

        return view('msl.users.create', compact('countries', 'markets', 'roles', 'languages'));
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless($request->user()?->can('users.manage'), 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:50'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'preferred_language_id' => ['nullable', 'integer', 'exists:languages,id'],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['string', 'exists:roles,name'],
            'countries' => ['nullable', 'array'],
            'countries.*' => ['integer', 'exists:countries,id'],
            'markets' => ['nullable', 'array'],
            'markets.*' => ['integer', 'exists:markets,id'],
        ]);

        foreach ($validated['countries'] ?? [] as $countryId) {
            abort_unless($request->user()?->hasCountryAccess((int) $countryId), 403);
        }

        $user = User::query()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'preferred_language_id' => $validated['preferred_language_id'] ?? null,
            'password' => Hash::make($validated['password']),
        ]);

        if (! empty($validated['roles'])) {
            $user->syncRoles($validated['roles']);
        }

        if (! empty($validated['countries'])) {
            $user->countries()->sync($validated['countries']);
        }

        if (! empty($validated['markets'])) {
            $user->markets()->sync($validated['markets']);
        }

        return redirect()
            ->route('msl.users.index')
            ->with('success', __('Utilisateur créé avec succès.'));
    }

    public function edit(User $user): View
    {
        abort_unless(auth()->user()?->can('users.manage'), 403);

        $user->load(['countries', 'markets', 'roles']);

        $countries = Country::query()
            ->whereIn('id', auth()->user()?->accessibleCountryIds() ?? [])
            ->orderBy('name')
            ->get(['id', 'name']);

        $markets = Market::query()
            ->whereIn('country_id', auth()->user()?->accessibleCountryIds() ?? [])
            ->orderBy('name')
            ->get(['id', 'name', 'country_id']);

        $roles = Role::query()->orderBy('name')->get(['id', 'name']);
        $languages = Language::query()->where('is_active', true)->orderBy('name')->get(['id', 'name']);

        return view('msl.users.edit', compact('user', 'countries', 'markets', 'roles', 'languages'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        abort_unless($request->user()?->can('users.manage'), 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:50'],
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'preferred_language_id' => ['nullable', 'integer', 'exists:languages,id'],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['string', 'exists:roles,name'],
            'countries' => ['nullable', 'array'],
            'countries.*' => ['integer', 'exists:countries,id'],
            'markets' => ['nullable', 'array'],
            'markets.*' => ['integer', 'exists:markets,id'],
        ]);

        foreach ($validated['countries'] ?? [] as $countryId) {
            abort_unless($request->user()?->hasCountryAccess((int) $countryId), 403);
        }

        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'preferred_language_id' => $validated['preferred_language_id'] ?? null,
        ]);

        if (! empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        $user->syncRoles($validated['roles'] ?? []);
        $user->countries()->sync($validated['countries'] ?? []);
        $user->markets()->sync($validated['markets'] ?? []);

        return redirect()
            ->route('msl.users.index')
            ->with('success', __('Utilisateur mis à jour avec succès.'));
    }

    public function destroy(User $user): RedirectResponse
    {
        abort_unless(auth()->user()?->can('users.manage'), 403);

        if ($user->id === auth()->id()) {
            return redirect()
                ->route('msl.users.index')
                ->with('error', __('Vous ne pouvez pas supprimer votre propre compte.'));
        }

        $user->delete();

        return redirect()
            ->route('msl.users.index')
            ->with('success', __('Utilisateur supprimé avec succès.'));
    }
}
