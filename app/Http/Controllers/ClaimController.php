<?php

namespace App\Http\Controllers;

use App\Concerns\ResolvesCountryFilter;
use App\Enums\ClaimStatus;
use App\Http\Requests\StoreClaimRequest;
use App\Models\BorderCrossing;
use App\Models\Claim;
use App\Models\ClaimType;
use App\Models\Country;
use App\Models\Market;
use App\Services\ClaimService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClaimController extends Controller
{
    use ResolvesCountryFilter;

    public function index(Request $request): View
    {
        $this->authorize('viewAny', Claim::class);

        $countryId = $this->resolveCountryId($request);
        $user = $request->user();

        $claims = Claim::query()
            ->with(['country', 'claimType.translations', 'user'])
            ->when($countryId, fn ($query) => $query->where('country_id', $countryId))
            ->when(! $user?->can('claims.review'), fn ($query) => $query->where('user_id', $user?->id))
            ->when(! $user?->isSuperAdmin() && $user?->can('claims.review'), function ($query) use ($user): void {
                $query->whereIn('country_id', $user?->accessibleCountryIds() ?? []);
            })
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $countries = Country::query()
            ->whereIn('id', $user?->accessibleCountryIds() ?? [])
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('pahewo.claims.index', [
            'claims' => $claims,
            'countries' => $countries,
            'countryId' => $countryId,
            'statuses' => ClaimStatus::cases(),
        ]);
    }

    public function create(Request $request): View
    {
        $this->authorize('create', Claim::class);

        $countries = Country::query()
            ->whereIn('id', $request->user()?->accessibleCountryIds() ?? [])
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        $claimTypes = ClaimType::query()
            ->with('translations')
            ->where('is_active', true)
            ->orderBy('code')
            ->get();

        $markets = Market::query()
            ->whereIn('country_id', $request->user()?->accessibleCountryIds() ?? [])
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'country_id']);

        $borderCrossings = BorderCrossing::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        $countryId = $this->resolveCountryId($request);

        return view('pahewo.claims.create', compact('countries', 'claimTypes', 'markets', 'borderCrossings', 'countryId'));
    }

    public function store(StoreClaimRequest $request, ClaimService $claimService): RedirectResponse
    {
        $this->authorize('create', Claim::class);

        $data = array_merge($request->validated(), [
            'user_id' => $request->user()->id,
        ]);

        $claim = $claimService->createClaim($data, $request->user());

        return redirect()
            ->route('pahewo.claims.show', $claim)
            ->with('success', __('Réclamation soumise avec succès.'));
    }

    public function show(Claim $claim): View
    {
        $this->authorize('view', $claim);

        $claim->load([
            'country',
            'claimType.translations',
            'market',
            'borderCrossing',
            'user',
            'statusHistories.changedBy',
            'attachments',
        ]);

        return view('pahewo.claims.show', compact('claim'));
    }

    public function edit(Claim $claim): View
    {
        $this->authorize('update', $claim);

        $countries = Country::query()
            ->whereIn('id', auth()->user()?->accessibleCountryIds() ?? [])
            ->orderBy('name')
            ->get(['id', 'name']);

        $claimTypes = ClaimType::query()
            ->with('translations')
            ->where('is_active', true)
            ->orderBy('code')
            ->get();

        return view('pahewo.claims.edit', compact('claim', 'countries', 'claimTypes'));
    }

    public function update(Request $request, Claim $claim): RedirectResponse
    {
        $this->authorize('update', $claim);

        $validated = $request->validate([
            'status' => ['required', 'string'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
        ]);

        $claim->update($validated);

        return redirect()
            ->route('pahewo.claims.show', $claim)
            ->with('success', __('Réclamation mise à jour avec succès.'));
    }

    public function destroy(Claim $claim): RedirectResponse
    {
        $this->authorize('delete', $claim);

        $claim->delete();

        return redirect()
            ->route('pahewo.claims.index')
            ->with('success', __('Réclamation supprimée avec succès.'));
    }
}
