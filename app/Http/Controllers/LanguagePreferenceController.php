<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LanguagePreferenceController extends Controller
{
    public function edit(): View
    {
        $languages = Language::query()->where('is_active', true)->orderBy('name')->get();

        return view('pahewo.language.edit', compact('languages'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'preferred_language_id' => ['required', 'exists:languages,id'],
        ]);

        $request->user()->update([
            'preferred_language_id' => $validated['preferred_language_id'],
        ]);

        return redirect()->route('pahewo.language')->with('success', __('Langue préférée mise à jour.'));
    }
}
