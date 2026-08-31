<?php

namespace App\Http\Controllers;

use App\Concerns\SyncsModelTranslation;
use App\Models\Commodity;
use App\Models\CommodityCategory;
use App\Models\MeasurementUnit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CommodityController extends Controller
{
    use SyncsModelTranslation;

    public function index(Request $request): View
    {
        abort_unless($request->user()?->can('commodities.view'), 403);

        $commodities = Commodity::query()
            ->with(['category.translations', 'unit.translations', 'translations'])
            ->when($request->filled('search'), fn ($q) => $q->where('code', 'like', '%'.$request->string('search').'%'))
            ->orderBy('code')
            ->paginate(15)
            ->withQueryString();

        return view('msl.commodities.index', compact('commodities'));
    }

    public function create(): View
    {
        abort_unless(auth()->user()?->can('commodities.create'), 403);

        $categories = CommodityCategory::query()->with('translations')->where('is_active', true)->orderBy('code')->get();
        $units = MeasurementUnit::query()->with('translations')->where('is_active', true)->orderBy('code')->get();

        return view('msl.commodities.create', compact('categories', 'units'));
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless($request->user()?->can('commodities.create'), 403);

        $validated = $request->validate([
            'commodity_category_id' => ['required', 'exists:commodity_categories,id'],
            'measurement_unit_id' => ['required', 'exists:measurement_units,id'],
            'code' => ['required', 'string', 'max:50', 'unique:commodities,code'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $commodity = Commodity::query()->create([
            'commodity_category_id' => $validated['commodity_category_id'],
            'measurement_unit_id' => $validated['measurement_unit_id'],
            'code' => $validated['code'],
            'is_active' => $request->boolean('is_active', true),
        ]);

        $this->syncTranslation($commodity, $commodity->translations(), [
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('msl.commodities.index')->with('success', __('Marchandise créée avec succès.'));
    }

    public function edit(Commodity $commodity): View
    {
        abort_unless(auth()->user()?->can('commodities.update'), 403);

        $commodity->load('translations');
        $categories = CommodityCategory::query()->with('translations')->where('is_active', true)->orderBy('code')->get();
        $units = MeasurementUnit::query()->with('translations')->where('is_active', true)->orderBy('code')->get();
        $translation = $commodity->translate();

        return view('msl.commodities.edit', compact('commodity', 'categories', 'units', 'translation'));
    }

    public function update(Request $request, Commodity $commodity): RedirectResponse
    {
        abort_unless($request->user()?->can('commodities.update'), 403);

        $validated = $request->validate([
            'commodity_category_id' => ['required', 'exists:commodity_categories,id'],
            'measurement_unit_id' => ['required', 'exists:measurement_units,id'],
            'code' => ['required', 'string', 'max:50', 'unique:commodities,code,'.$commodity->id],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $commodity->update([
            'commodity_category_id' => $validated['commodity_category_id'],
            'measurement_unit_id' => $validated['measurement_unit_id'],
            'code' => $validated['code'],
            'is_active' => $request->boolean('is_active', false),
        ]);

        $this->syncTranslation($commodity, $commodity->translations(), [
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('msl.commodities.index')->with('success', __('Marchandise mise à jour avec succès.'));
    }

    public function destroy(Request $request, Commodity $commodity): RedirectResponse
    {
        abort_unless($request->user()?->can('commodities.delete'), 403);

        $commodity->delete();

        return redirect()->route('msl.commodities.index')->with('success', __('Marchandise supprimée avec succès.'));
    }
}
