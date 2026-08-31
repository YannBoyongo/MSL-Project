<?php

namespace App\Http\Controllers;

use App\Concerns\SyncsModelTranslation;
use App\Models\CommodityCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CommodityCategoryController extends Controller
{
    use SyncsModelTranslation;

    public function index(Request $request): View
    {
        abort_unless($request->user()?->can('commodities.view'), 403);

        $categories = CommodityCategory::query()
            ->with('translations')
            ->when($request->filled('search'), fn ($q) => $q->where('code', 'like', '%'.$request->string('search').'%'))
            ->orderBy('code')
            ->paginate(15)
            ->withQueryString();

        return view('msl.commodity-categories.index', compact('categories'));
    }

    public function create(): View
    {
        abort_unless(auth()->user()?->can('commodities.create'), 403);

        return view('msl.commodity-categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless($request->user()?->can('commodities.create'), 403);

        $validated = $request->validate([
            'code' => ['required', 'string', 'max:50', 'unique:commodity_categories,code'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $category = CommodityCategory::query()->create([
            'code' => $validated['code'],
            'is_active' => $request->boolean('is_active', true),
        ]);

        $this->syncTranslation($category, $category->translations(), [
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('msl.commodity-categories.index')->with('success', __('Catégorie créée avec succès.'));
    }

    public function edit(CommodityCategory $commodityCategory): View
    {
        abort_unless(auth()->user()?->can('commodities.update'), 403);

        $commodityCategory->load('translations');
        $translation = $commodityCategory->translate();

        return view('msl.commodity-categories.edit', compact('commodityCategory', 'translation'));
    }

    public function update(Request $request, CommodityCategory $commodityCategory): RedirectResponse
    {
        abort_unless($request->user()?->can('commodities.update'), 403);

        $validated = $request->validate([
            'code' => ['required', 'string', 'max:50', 'unique:commodity_categories,code,'.$commodityCategory->id],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $commodityCategory->update([
            'code' => $validated['code'],
            'is_active' => $request->boolean('is_active', false),
        ]);

        $this->syncTranslation($commodityCategory, $commodityCategory->translations(), [
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('msl.commodity-categories.index')->with('success', __('Catégorie mise à jour avec succès.'));
    }

    public function destroy(Request $request, CommodityCategory $commodityCategory): RedirectResponse
    {
        abort_unless($request->user()?->can('commodities.delete'), 403);

        $commodityCategory->delete();

        return redirect()->route('msl.commodity-categories.index')->with('success', __('Catégorie supprimée avec succès.'));
    }
}
