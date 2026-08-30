<x-pahewo-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Bureaux de change</h2>
            @can('exchange_rates.create')
                <a href="{{ route('pahewo.forex-bureaus.create') }}" class="inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-sm text-white">Nouveau bureau</a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                @include('pahewo.partials.flash')
                @include('pahewo.partials.country-filter')

                <x-search-filter />

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b text-left text-gray-500">
                                <th class="py-2 pr-4">Nom</th>
                                <th class="py-2 pr-4">Pays</th>
                                <th class="py-2 pr-4">Ville</th>
                                <th class="py-2 pr-4">Téléphone</th>
                                <th class="py-2 pr-4">Statut</th>
                                <th class="py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($forexBureaus as $bureau)
                                <tr class="border-b">
                                    <td class="py-2 pr-4">{{ $bureau->name }}</td>
                                    <td class="py-2 pr-4">{{ $bureau->country?->name }}</td>
                                    <td class="py-2 pr-4">{{ $bureau->city }}</td>
                                    <td class="py-2 pr-4">{{ $bureau->phone ?? '-' }}</td>
                                    <td class="py-2 pr-4">{{ $bureau->is_active ? 'Actif' : 'Inactif' }}</td>
                                    <td class="py-2">
                                        @can('exchange_rates.update')
                                            <a href="{{ route('pahewo.forex-bureaus.edit', $bureau) }}" class="text-indigo-600 hover:underline">Modifier</a>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="py-6 text-center text-gray-500">Aucun bureau de change trouvé.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">{{ $forexBureaus->links() }}</div>
            </div>
        </div>
    </div>
</x-pahewo-layout>
