<?php

namespace App\Http\Controllers;

use App\Concerns\ResolvesCountryFilter;
use App\Models\BorderCrossing;
use App\Models\ContactPerson;
use App\Models\Country;
use App\Models\Market;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactPersonController extends Controller
{
    use ResolvesCountryFilter;

    public function index(Request $request): View
    {
        abort_unless($request->user()?->can('users.manage') || $request->user()?->isSuperAdmin(), 403);

        $countryId = $this->resolveCountryId($request);

        $contactPersons = ContactPerson::query()
            ->with(['country', 'market', 'borderCrossing'])
            ->when($countryId, fn ($query) => $query->where('country_id', $countryId))
            ->when(! $request->user()?->isSuperAdmin(), function ($query) use ($request): void {
                $query->whereIn('country_id', $request->user()?->accessibleCountryIds() ?? []);
            })
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        $countries = Country::query()
            ->whereIn('id', $request->user()?->accessibleCountryIds() ?? [])
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('msl.contact-persons.index', compact('contactPersons', 'countries', 'countryId'));
    }

    public function create(Request $request): View
    {
        abort_unless($request->user()?->can('users.manage') || $request->user()?->isSuperAdmin(), 403);

        $countries = Country::query()
            ->whereIn('id', $request->user()?->accessibleCountryIds() ?? [])
            ->orderBy('name')
            ->get(['id', 'name']);

        $markets = Market::query()
            ->whereIn('country_id', $request->user()?->accessibleCountryIds() ?? [])
            ->orderBy('name')
            ->get(['id', 'name', 'country_id']);

        $borderCrossings = BorderCrossing::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('msl.contact-persons.create', compact('countries', 'markets', 'borderCrossings'));
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless($request->user()?->can('users.manage') || $request->user()?->isSuperAdmin(), 403);

        $validated = $request->validate([
            'country_id' => ['nullable', 'integer', 'exists:countries,id'],
            'border_crossing_id' => ['nullable', 'integer', 'exists:border_crossings,id'],
            'market_id' => ['nullable', 'integer', 'exists:markets,id'],
            'name' => ['required', 'string', 'max:255'],
            'organization' => ['nullable', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        if ($validated['country_id'] ?? null) {
            abort_unless($request->user()?->hasCountryAccess((int) $validated['country_id']), 403);
        }

        $validated['is_active'] = $request->boolean('is_active', true);

        ContactPerson::query()->create($validated);

        return redirect()
            ->route('msl.contact-persons.index')
            ->with('success', __('Personne de contact créée avec succès.'));
    }

    public function edit(ContactPerson $contactPerson): View
    {
        abort_unless(auth()->user()?->can('users.manage') || auth()->user()?->isSuperAdmin(), 403);

        if ($contactPerson->country_id !== null) {
            abort_unless(auth()->user()?->hasCountryAccess($contactPerson->country_id), 403);
        }

        $countries = Country::query()
            ->whereIn('id', auth()->user()?->accessibleCountryIds() ?? [])
            ->orderBy('name')
            ->get(['id', 'name']);

        $markets = Market::query()
            ->whereIn('country_id', auth()->user()?->accessibleCountryIds() ?? [])
            ->orderBy('name')
            ->get(['id', 'name', 'country_id']);

        $borderCrossings = BorderCrossing::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('msl.contact-persons.edit', compact('contactPerson', 'countries', 'markets', 'borderCrossings'));
    }

    public function update(Request $request, ContactPerson $contactPerson): RedirectResponse
    {
        abort_unless($request->user()?->can('users.manage') || $request->user()?->isSuperAdmin(), 403);

        $validated = $request->validate([
            'country_id' => ['nullable', 'integer', 'exists:countries,id'],
            'border_crossing_id' => ['nullable', 'integer', 'exists:border_crossings,id'],
            'market_id' => ['nullable', 'integer', 'exists:markets,id'],
            'name' => ['required', 'string', 'max:255'],
            'organization' => ['nullable', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        if ($validated['country_id'] ?? null) {
            abort_unless($request->user()?->hasCountryAccess((int) $validated['country_id']), 403);
        }

        $validated['is_active'] = $request->boolean('is_active', false);

        $contactPerson->update($validated);

        return redirect()
            ->route('msl.contact-persons.index')
            ->with('success', __('Personne de contact mise à jour avec succès.'));
    }

    public function destroy(ContactPerson $contactPerson): RedirectResponse
    {
        abort_unless(auth()->user()?->can('users.manage') || auth()->user()?->isSuperAdmin(), 403);

        if ($contactPerson->country_id !== null) {
            abort_unless(auth()->user()?->hasCountryAccess($contactPerson->country_id), 403);
        }

        $contactPerson->delete();

        return redirect()
            ->route('msl.contact-persons.index')
            ->with('success', __('Personne de contact supprimée avec succès.'));
    }
}
