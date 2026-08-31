<x-msl-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Réclamations</h2>
            @can('create', App\Models\Claim::class)
                <a href="{{ route('msl.claims.create') }}" class="inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-sm text-white">Nouvelle réclamation</a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                @include('msl.partials.flash')
                @include('msl.partials.country-filter')

                <form method="GET" class="mb-4 flex flex-wrap items-end gap-3">
                    <x-query-hidden-fields :except="['status', 'page']" />
                    <div>
                        <x-input-label for="status" value="Statut" />
                        <select id="status" name="status" class="mt-1 block rounded-md border-gray-300 shadow-sm">
                            <option value="">Tous les statuts</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status->value }}" @selected(request('status') === $status->value)>{{ $status->label() }}</option>
                            @endforeach
                        </select>
                    </div>
                    <x-primary-button type="submit">Filtrer</x-primary-button>
                </form>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b text-left text-gray-500">
                                <th class="py-2 pr-4">Référence</th>
                                <th class="py-2 pr-4">Titre</th>
                                <th class="py-2 pr-4">Pays</th>
                                <th class="py-2 pr-4">Statut</th>
                                <th class="py-2 pr-4">Date</th>
                                <th class="py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($claims as $claim)
                                <tr class="border-b">
                                    <td class="py-2 pr-4">{{ $claim->reference_number }}</td>
                                    <td class="py-2 pr-4">{{ $claim->title }}</td>
                                    <td class="py-2 pr-4">{{ $claim->country?->name }}</td>
                                    <td class="py-2 pr-4">{{ $claim->status?->label() }}</td>
                                    <td class="py-2 pr-4">{{ $claim->created_at?->format('d/m/Y') }}</td>
                                    <td class="py-2">
                                        <a href="{{ route('msl.claims.show', $claim) }}" class="text-indigo-600 hover:underline">Voir</a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="py-6 text-center text-gray-500">Aucune réclamation trouvée.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">{{ $claims->links() }}</div>
            </div>
        </div>
    </div>
</x-msl-layout>

