<x-pahewo-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Catégories de marchandises</h2>
            @can('commodities.create')
                <a href="{{ route('pahewo.commodity-categories.create') }}" class="inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-sm text-white">Nouvelle catégorie</a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                @include('pahewo.partials.flash')

                <x-search-filter placeholder="Rechercher par code..." />

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b text-left text-gray-500">
                                <th class="py-2 pr-4">Code</th>
                                <th class="py-2 pr-4">Nom</th>
                                <th class="py-2 pr-4">Statut</th>
                                <th class="py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                                <tr class="border-b">
                                    <td class="py-2 pr-4">{{ $category->code }}</td>
                                    <td class="py-2 pr-4">{{ $category->translate_name ?? '-' }}</td>
                                    <td class="py-2 pr-4">{{ $category->is_active ? 'Actif' : 'Inactif' }}</td>
                                    <td class="py-2">
                                        @can('commodities.update')
                                            <a href="{{ route('pahewo.commodity-categories.edit', $category) }}" class="text-indigo-600 hover:underline">Modifier</a>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="py-6 text-center text-gray-500">Aucune catégorie trouvée.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">{{ $categories->links() }}</div>
            </div>
        </div>
    </div>
</x-pahewo-layout>
