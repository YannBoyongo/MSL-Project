<x-msl-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Rapports</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @include('msl.partials.flash')

            <div class="rounded-lg bg-white p-6 shadow-sm">
                @include('msl.partials.country-filter')
            </div>

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <a href="{{ route('msl.reports.price-trends', request()->only('country_id')) }}" class="rounded-lg bg-white p-6 shadow-sm hover:ring-2 hover:ring-indigo-200">
                    <h3 class="font-medium text-gray-800">Tendances des prix</h3>
                    <p class="mt-1 text-sm text-gray-500">Évolution des prix par marchandise</p>
                </a>
                <a href="{{ route('msl.reports.exchange-rate-trends', request()->only('country_id')) }}" class="rounded-lg bg-white p-6 shadow-sm hover:ring-2 hover:ring-indigo-200">
                    <h3 class="font-medium text-gray-800">Tendances des taux</h3>
                    <p class="mt-1 text-sm text-gray-500">Évolution des taux de change</p>
                </a>
                <a href="{{ route('msl.reports.claims', request()->only('country_id')) }}" class="rounded-lg bg-white p-6 shadow-sm hover:ring-2 hover:ring-indigo-200">
                    <h3 class="font-medium text-gray-800">Réclamations</h3>
                    <p class="mt-1 text-sm text-gray-500">Statistiques des réclamations</p>
                </a>
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                <div class="rounded-lg bg-white p-6 shadow-sm">
                    <h3 class="mb-4 text-lg font-medium">Résumé des réclamations</h3>
                    <dl class="grid gap-3 text-sm sm:grid-cols-2">
                        <div>
                            <dt class="text-gray-500">Total</dt>
                            <dd class="text-xl font-semibold">{{ $claimSummary['total'] }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Non résolues</dt>
                            <dd class="text-xl font-semibold">{{ $claimSummary['unresolved'] }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="rounded-lg bg-white p-6 shadow-sm">
                    <h3 class="mb-4 text-lg font-medium">Collecte par pays</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="border-b text-left text-gray-500">
                                    <th class="py-2 pr-4">Pays</th>
                                    <th class="py-2 pr-4">Attendu</th>
                                    <th class="py-2 pr-4">Réel</th>
                                    <th class="py-2">%</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($collectionSummary as $row)
                                    <tr class="border-b">
                                        <td class="py-2 pr-4">{{ $row['country_name'] }}</td>
                                        <td class="py-2 pr-4">{{ $row['expected'] }}</td>
                                        <td class="py-2 pr-4">{{ $row['actual'] }}</td>
                                        <td class="py-2">{{ $row['percentage'] }}%</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="py-4 text-gray-500">Aucune donnée.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-msl-layout>

