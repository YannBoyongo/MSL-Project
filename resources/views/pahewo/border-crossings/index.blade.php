<x-pahewo-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Postes frontaliers</h2>
            @can('travel_documents.manage')
                <a href="{{ route('pahewo.border-crossings.create') }}" class="inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-sm text-white">Nouveau poste</a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                @include('pahewo.partials.flash')

                <x-search-filter />

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b text-left text-gray-500">
                                <th class="py-2 pr-4">Nom</th>
                                <th class="py-2 pr-4">Pays A</th>
                                <th class="py-2 pr-4">Pays B</th>
                                <th class="py-2 pr-4">Statut</th>
                                <th class="py-2 pr-4">Horaires</th>
                                <th class="py-2 pr-4">Actif</th>
                                <th class="py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($borderCrossings as $crossing)
                                <tr class="border-b">
                                    <td class="py-2 pr-4">{{ $crossing->name }}</td>
                                    <td class="py-2 pr-4">{{ $crossing->countryA?->name }}</td>
                                    <td class="py-2 pr-4">{{ $crossing->countryB?->name }}</td>
                                    <td class="py-2 pr-4">{{ $crossing->status?->label() }}</td>
                                    <td class="py-2 pr-4">
                                        @if ($crossing->opening_time || $crossing->closing_time)
                                            {{ $crossing->opening_time ? substr($crossing->opening_time, 0, 5) : '-' }}
                                            -
                                            {{ $crossing->closing_time ? substr($crossing->closing_time, 0, 5) : '-' }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="py-2 pr-4">{{ $crossing->is_active ? 'Oui' : 'Non' }}</td>
                                    <td class="py-2">
                                        @can('travel_documents.manage')
                                            <a href="{{ route('pahewo.border-crossings.edit', $crossing) }}" class="text-indigo-600 hover:underline">Modifier</a>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="py-6 text-center text-gray-500">Aucun poste frontalier trouvé.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">{{ $borderCrossings->links() }}</div>
            </div>
        </div>
    </div>
</x-pahewo-layout>
