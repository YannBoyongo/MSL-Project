<?php

namespace App\Http\Controllers;

use App\Concerns\SyncsModelTranslation;
use App\Models\ClaimType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClaimTypeController extends Controller
{
    use SyncsModelTranslation;

    public function index(Request $request): View
    {
        abort_unless($request->user()?->can('claims.review'), 403);

        $claimTypes = ClaimType::query()
            ->with('translations')
            ->when($request->filled('search'), fn ($q) => $q->where('code', 'like', '%'.$request->string('search').'%'))
            ->orderBy('code')
            ->paginate(15)
            ->withQueryString();

        return view('msl.claim-types.index', compact('claimTypes'));
    }

    public function create(): View
    {
        abort_unless(auth()->user()?->can('claims.review'), 403);

        return view('msl.claim-types.create');
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless($request->user()?->can('claims.review'), 403);

        $validated = $request->validate([
            'code' => ['required', 'string', 'max:50', 'unique:claim_types,code'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $claimType = ClaimType::query()->create([
            'code' => $validated['code'],
            'is_active' => $request->boolean('is_active', true),
        ]);

        $this->syncTranslation($claimType, $claimType->translations(), [
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('msl.claim-types.index')->with('success', __('Type de réclamation créé avec succès.'));
    }

    public function edit(ClaimType $claimType): View
    {
        abort_unless(auth()->user()?->can('claims.review'), 403);

        $claimType->load('translations');
        $translation = $claimType->translate();

        return view('msl.claim-types.edit', compact('claimType', 'translation'));
    }

    public function update(Request $request, ClaimType $claimType): RedirectResponse
    {
        abort_unless($request->user()?->can('claims.review'), 403);

        $validated = $request->validate([
            'code' => ['required', 'string', 'max:50', 'unique:claim_types,code,'.$claimType->id],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $claimType->update([
            'code' => $validated['code'],
            'is_active' => $request->boolean('is_active', false),
        ]);

        $this->syncTranslation($claimType, $claimType->translations(), [
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('msl.claim-types.index')->with('success', __('Type de réclamation mis à jour avec succès.'));
    }

    public function destroy(Request $request, ClaimType $claimType): RedirectResponse
    {
        abort_unless($request->user()?->can('claims.review'), 403);

        $claimType->delete();

        return redirect()->route('msl.claim-types.index')->with('success', __('Type de réclamation supprimé avec succès.'));
    }
}
