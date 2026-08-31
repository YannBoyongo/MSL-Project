<?php

namespace App\Http\Controllers;

use App\Concerns\ResolvesCountryFilter;
use App\Models\Country;
use App\Models\TravelDocument;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TravelRequirementsController extends Controller
{
    use ResolvesCountryFilter;

    public function index(Request $request): View
    {
        abort_unless($request->user()?->can('travel_documents.view'), 403);

        $countryId = $this->resolveCountryId($request);

        $documents = TravelDocument::query()
            ->with(['country', 'documentType.translations', 'feeCurrency', 'translations'])
            ->when($countryId, fn ($q) => $q->where('country_id', $countryId))
            ->when(! $request->user()?->isSuperAdmin(), fn ($q) => $q->whereIn('country_id', $request->user()?->accessibleCountryIds() ?? []))
            ->where('is_active', true)
            ->orderBy('country_id')
            ->get()
            ->groupBy(fn (TravelDocument $doc) => $doc->country?->name ?? '-');

        $countries = Country::query()
            ->whereIn('id', $request->user()?->accessibleCountryIds() ?? [])
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('msl.travel-requirements.index', compact('documents', 'countries', 'countryId'));
    }
}
