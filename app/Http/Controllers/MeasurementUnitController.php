<?php

namespace App\Http\Controllers;

use App\Concerns\SyncsModelTranslation;
use App\Models\MeasurementUnit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MeasurementUnitController extends Controller
{
    use SyncsModelTranslation;

    public function index(Request $request): View
    {
        abort_unless($request->user()?->can('commodities.view'), 403);

        $units = MeasurementUnit::query()
            ->with('translations')
            ->when($request->filled('search'), fn ($q) => $q->where('code', 'like', '%'.$request->string('search').'%'))
            ->orderBy('code')
            ->paginate(15)
            ->withQueryString();

        return view('msl.measurement-units.index', compact('units'));
    }

    public function create(): View
    {
        abort_unless(auth()->user()?->can('commodities.create'), 403);

        return view('msl.measurement-units.create');
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless($request->user()?->can('commodities.create'), 403);

        $validated = $request->validate([
            'code' => ['required', 'string', 'max:50', 'unique:measurement_units,code'],
            'symbol' => ['required', 'string', 'max:20'],
            'name' => ['required', 'string', 'max:255'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $unit = MeasurementUnit::query()->create([
            'code' => $validated['code'],
            'symbol' => $validated['symbol'],
            'is_active' => $request->boolean('is_active', true),
        ]);

        $this->syncTranslation($unit, $unit->translations(), ['name' => $validated['name']]);

        return redirect()->route('msl.measurement-units.index')->with('success', __('Unité de mesure créée avec succès.'));
    }

    public function edit(MeasurementUnit $measurementUnit): View
    {
        abort_unless(auth()->user()?->can('commodities.update'), 403);

        $measurementUnit->load('translations');
        $translation = $measurementUnit->translate();

        return view('msl.measurement-units.edit', compact('measurementUnit', 'translation'));
    }

    public function update(Request $request, MeasurementUnit $measurementUnit): RedirectResponse
    {
        abort_unless($request->user()?->can('commodities.update'), 403);

        $validated = $request->validate([
            'code' => ['required', 'string', 'max:50', 'unique:measurement_units,code,'.$measurementUnit->id],
            'symbol' => ['required', 'string', 'max:20'],
            'name' => ['required', 'string', 'max:255'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $measurementUnit->update([
            'code' => $validated['code'],
            'symbol' => $validated['symbol'],
            'is_active' => $request->boolean('is_active', false),
        ]);

        $this->syncTranslation($measurementUnit, $measurementUnit->translations(), ['name' => $validated['name']]);

        return redirect()->route('msl.measurement-units.index')->with('success', __('Unité de mesure mise à jour avec succès.'));
    }

    public function destroy(Request $request, MeasurementUnit $measurementUnit): RedirectResponse
    {
        abort_unless($request->user()?->can('commodities.delete'), 403);

        $measurementUnit->delete();

        return redirect()->route('msl.measurement-units.index')->with('success', __('Unité de mesure supprimée avec succès.'));
    }
}
