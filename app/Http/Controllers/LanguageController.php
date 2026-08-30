<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LanguageController extends Controller
{
    public function index(): View
    {
        abort_unless(auth()->user()?->can('countries.manage'), 403);

        $languages = Language::query()->orderBy('name')->paginate(15);

        return view('pahewo.languages.index', compact('languages'));
    }

    public function create(): View
    {
        abort_unless(auth()->user()?->can('countries.manage'), 403);

        return view('pahewo.languages.create');
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless($request->user()?->can('countries.manage'), 403);

        $validated = $request->validate([
            'code' => ['required', 'string', 'max:5', 'unique:languages,code'],
            'name' => ['required', 'string', 'max:255'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        Language::query()->create($validated);

        return redirect()->route('pahewo.languages.index')->with('success', __('Langue créée avec succès.'));
    }

    public function edit(Language $language): View
    {
        abort_unless(auth()->user()?->can('countries.manage'), 403);

        return view('pahewo.languages.edit', compact('language'));
    }

    public function update(Request $request, Language $language): RedirectResponse
    {
        abort_unless($request->user()?->can('countries.manage'), 403);

        $validated = $request->validate([
            'code' => ['required', 'string', 'max:5', 'unique:languages,code,'.$language->id],
            'name' => ['required', 'string', 'max:255'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', false);

        $language->update($validated);

        return redirect()->route('pahewo.languages.index')->with('success', __('Langue mise à jour avec succès.'));
    }

    public function destroy(Request $request, Language $language): RedirectResponse
    {
        abort_unless($request->user()?->can('countries.manage'), 403);

        $language->delete();

        return redirect()->route('pahewo.languages.index')->with('success', __('Langue supprimée avec succès.'));
    }
}
