<x-msl-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Documents de voyage</h2>
            @can('travel_documents.manage')
                <a href="{{ route('msl.travel-documents.create') }}" class="inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-sm text-white">Nouveau document</a>
            @endcan
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                @include('msl.partials.flash')
                @include('msl.partials.country-filter')
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead><tr class="border-b text-left text-gray-500"><th class="py-2 pr-4">Titre</th><th class="py-2 pr-4">Pays</th><th class="py-2 pr-4">Obligatoire</th><th class="py-2">Actions</th></tr></thead>
                        <tbody>
                            @forelse ($travelDocuments as $doc)
                                <tr class="border-b">
                                    <td class="py-2 pr-4">{{ $doc->translate_name }}</td>
                                    <td class="py-2 pr-4">{{ $doc->country?->name }}</td>
                                    <td class="py-2 pr-4">{{ $doc->is_required ? 'Oui' : 'Non' }}</td>
                                    <td class="py-2">@can('travel_documents.manage')<a href="{{ route('msl.travel-documents.edit', $doc) }}" class="text-indigo-600 hover:underline">Modifier</a>@endcan</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="py-6 text-center text-gray-500">Aucun document.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $travelDocuments->links() }}</div>
            </div>
        </div>
    </div>
</x-msl-layout>

