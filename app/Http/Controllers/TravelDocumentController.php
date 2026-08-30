<?php

namespace App\Http\Controllers;

use App\Concerns\ResolvesCountryFilter;
use App\Models\Country;
use App\Models\Currency;
use App\Models\DocumentType;
use App\Models\Language;
use App\Models\TravelDocument;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TravelDocumentController extends Controller
{
    use ResolvesCountryFilter;

    public function index(Request $request): View
    {
        abort_unless($request->user()?->can('travel_documents.view'), 403);

        $countryId = $this->resolveCountryId($request);

        $travelDocuments = TravelDocument::query()
            ->with(['country', 'documentType.translations', 'feeCurrency', 'translations'])
            ->when($countryId, fn ($query) => $query->where('country_id', $countryId))
            ->when(! $request->user()?->isSuperAdmin(), function ($query) use ($request): void {
                $query->whereIn('country_id', $request->user()?->accessibleCountryIds() ?? []);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $countries = Country::query()
            ->whereIn('id', $request->user()?->accessibleCountryIds() ?? [])
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('pahewo.travel-documents.index', compact('travelDocuments', 'countries', 'countryId'));
    }

    public function create(Request $request): View
    {
        abort_unless($request->user()?->can('travel_documents.manage'), 403);

        $countries = Country::query()
            ->whereIn('id', $request->user()?->accessibleCountryIds() ?? [])
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        $documentTypes = DocumentType::query()
            ->with('translations')
            ->where('is_active', true)
            ->orderBy('code')
            ->get();

        $currencies = Currency::query()
            ->where('is_active', true)
            ->orderBy('code')
            ->get(['id', 'code', 'name']);

        $languages = Language::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'code']);

        $countryId = $this->resolveCountryId($request);

        return view('pahewo.travel-documents.create', compact('countries', 'documentTypes', 'currencies', 'languages', 'countryId'));
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless($request->user()?->can('travel_documents.manage'), 403);

        $validated = $request->validate([
            'country_id' => ['required', 'integer', 'exists:countries,id'],
            'document_type_id' => ['required', 'integer', 'exists:document_types,id'],
            'is_required' => ['sometimes', 'boolean'],
            'validity_days' => ['nullable', 'integer', 'min:0'],
            'fee' => ['nullable', 'numeric', 'min:0'],
            'fee_currency_id' => ['nullable', 'integer', 'exists:currencies,id'],
            'is_active' => ['sometimes', 'boolean'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'language_id' => ['required', 'integer', 'exists:languages,id'],
        ]);

        abort_unless($request->user()?->hasCountryAccess((int) $validated['country_id']), 403);

        $document = TravelDocument::query()->create([
            'country_id' => $validated['country_id'],
            'document_type_id' => $validated['document_type_id'],
            'is_required' => $request->boolean('is_required'),
            'validity_days' => $validated['validity_days'] ?? null,
            'fee' => $validated['fee'] ?? null,
            'fee_currency_id' => $validated['fee_currency_id'] ?? null,
            'is_active' => $request->boolean('is_active', true),
        ]);

        $document->translations()->create([
            'language_id' => $validated['language_id'],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()
            ->route('pahewo.travel-documents.index')
            ->with('success', __('Document de voyage créé avec succès.'));
    }

    public function edit(TravelDocument $travelDocument): View
    {
        abort_unless(
            auth()->user()?->can('travel_documents.manage')
            && auth()->user()?->hasCountryAccess($travelDocument->country_id),
            403
        );

        $travelDocument->load('translations');

        $countries = Country::query()
            ->whereIn('id', auth()->user()?->accessibleCountryIds() ?? [])
            ->orderBy('name')
            ->get(['id', 'name']);

        $documentTypes = DocumentType::query()
            ->with('translations')
            ->where('is_active', true)
            ->orderBy('code')
            ->get();

        $currencies = Currency::query()
            ->where('is_active', true)
            ->orderBy('code')
            ->get(['id', 'code', 'name']);

        $languages = Language::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'code']);

        return view('pahewo.travel-documents.edit', compact('travelDocument', 'countries', 'documentTypes', 'currencies', 'languages'));
    }

    public function update(Request $request, TravelDocument $travelDocument): RedirectResponse
    {
        abort_unless(
            $request->user()?->can('travel_documents.manage')
            && $request->user()?->hasCountryAccess($travelDocument->country_id),
            403
        );

        $validated = $request->validate([
            'country_id' => ['required', 'integer', 'exists:countries,id'],
            'document_type_id' => ['required', 'integer', 'exists:document_types,id'],
            'is_required' => ['sometimes', 'boolean'],
            'validity_days' => ['nullable', 'integer', 'min:0'],
            'fee' => ['nullable', 'numeric', 'min:0'],
            'fee_currency_id' => ['nullable', 'integer', 'exists:currencies,id'],
            'is_active' => ['sometimes', 'boolean'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'language_id' => ['required', 'integer', 'exists:languages,id'],
        ]);

        abort_unless($request->user()?->hasCountryAccess((int) $validated['country_id']), 403);

        $travelDocument->update([
            'country_id' => $validated['country_id'],
            'document_type_id' => $validated['document_type_id'],
            'is_required' => $request->boolean('is_required'),
            'validity_days' => $validated['validity_days'] ?? null,
            'fee' => $validated['fee'] ?? null,
            'fee_currency_id' => $validated['fee_currency_id'] ?? null,
            'is_active' => $request->boolean('is_active', false),
        ]);

        $travelDocument->translations()->updateOrCreate(
            ['language_id' => $validated['language_id']],
            [
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
            ]
        );

        return redirect()
            ->route('pahewo.travel-documents.index')
            ->with('success', __('Document de voyage mis à jour avec succès.'));
    }

    public function destroy(TravelDocument $travelDocument): RedirectResponse
    {
        abort_unless(
            auth()->user()?->can('travel_documents.manage')
            && auth()->user()?->hasCountryAccess($travelDocument->country_id),
            403
        );

        $travelDocument->delete();

        return redirect()
            ->route('pahewo.travel-documents.index')
            ->with('success', __('Document de voyage supprimé avec succès.'));
    }
}
