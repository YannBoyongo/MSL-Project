<?php

namespace App\Http\Controllers;

use App\Enums\BorderStatus;
use App\Models\BorderCrossing;
use App\Models\Country;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BorderCrossingController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless($request->user()?->can('travel_documents.view'), 403);

        $borderCrossings = BorderCrossing::query()
            ->with(['countryA', 'countryB'])
            ->when($request->filled('search'), fn ($q) => $q->where('name', 'like', '%'.$request->string('search').'%'))
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('pahewo.border-crossings.index', compact('borderCrossings'));
    }

    public function create(): View
    {
        abort_unless(auth()->user()?->can('travel_documents.manage'), 403);

        $countries = Country::query()->where('is_active', true)->orderBy('name')->get(['id', 'name']);
        $statuses = BorderStatus::cases();

        return view('pahewo.border-crossings.create', compact('countries', 'statuses'));
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless($request->user()?->can('travel_documents.manage'), 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'country_a_id' => ['required', 'exists:countries,id'],
            'country_b_id' => ['required', 'exists:countries,id', 'different:country_a_id'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'opening_time' => ['nullable', 'date_format:H:i'],
            'closing_time' => ['nullable', 'date_format:H:i'],
            'status' => ['required', Rule::enum(BorderStatus::class)],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        BorderCrossing::query()->create($validated);

        return redirect()->route('pahewo.border-crossings.index')->with('success', __('Poste frontalier créé avec succès.'));
    }

    public function edit(BorderCrossing $borderCrossing): View
    {
        abort_unless(auth()->user()?->can('travel_documents.manage'), 403);

        $countries = Country::query()->where('is_active', true)->orderBy('name')->get(['id', 'name']);
        $statuses = BorderStatus::cases();

        return view('pahewo.border-crossings.edit', compact('borderCrossing', 'countries', 'statuses'));
    }

    public function update(Request $request, BorderCrossing $borderCrossing): RedirectResponse
    {
        abort_unless($request->user()?->can('travel_documents.manage'), 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'country_a_id' => ['required', 'exists:countries,id'],
            'country_b_id' => ['required', 'exists:countries,id', 'different:country_a_id'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'opening_time' => ['nullable', 'date_format:H:i'],
            'closing_time' => ['nullable', 'date_format:H:i'],
            'status' => ['required', Rule::enum(BorderStatus::class)],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', false);

        $borderCrossing->update($validated);

        return redirect()->route('pahewo.border-crossings.index')->with('success', __('Poste frontalier mis à jour avec succès.'));
    }

    public function destroy(Request $request, BorderCrossing $borderCrossing): RedirectResponse
    {
        abort_unless($request->user()?->can('travel_documents.manage'), 403);

        $borderCrossing->delete();

        return redirect()->route('pahewo.border-crossings.index')->with('success', __('Poste frontalier supprimé avec succès.'));
    }
}
