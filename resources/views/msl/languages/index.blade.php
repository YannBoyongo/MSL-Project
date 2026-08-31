<x-msl-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Langues</h2>
            @can('countries.manage')
                <a href="{{ route('msl.languages.create') }}" class="inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-sm text-white">Nouvelle langue</a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                @include('msl.partials.flash')

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
                            @forelse ($languages as $language)
                                <tr class="border-b">
                                    <td class="py-2 pr-4">{{ $language->code }}</td>
                                    <td class="py-2 pr-4">{{ $language->name }}</td>
                                    <td class="py-2 pr-4">{{ $language->is_active ? 'Actif' : 'Inactif' }}</td>
                                    <td class="py-2">
                                        @can('countries.manage')
                                            <a href="{{ route('msl.languages.edit', $language) }}" class="text-indigo-600 hover:underline">Modifier</a>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="py-6 text-center text-gray-500">Aucune langue enregistrée.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">{{ $languages->links() }}</div>
            </div>
        </div>
    </div>
</x-msl-layout>

