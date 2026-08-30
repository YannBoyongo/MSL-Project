<x-pahewo-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tableau de bord - Administration</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @include('pahewo.partials.flash')

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-lg bg-white p-6 shadow-sm">
                    <p class="text-sm text-gray-500">Prix du jour</p>
                    <p class="text-2xl font-semibold">{{ $todayPriceCount }}</p>
                </div>
                <div class="rounded-lg bg-white p-6 shadow-sm">
                    <p class="text-sm text-gray-500">Taux du jour</p>
                    <p class="text-2xl font-semibold">{{ $todayExchangeRateCount }}</p>
                </div>
                <div class="rounded-lg bg-white p-6 shadow-sm">
                    <p class="text-sm text-gray-500">Collecte des prix</p>
                    <p class="text-2xl font-semibold">{{ $priceCollectionCompletion['percentage'] }}%</p>
                </div>
                <div class="rounded-lg bg-white p-6 shadow-sm">
                    <p class="text-sm text-gray-500">Réclamations non résolues</p>
                    <p class="text-2xl font-semibold">{{ $claimSummary['unresolved'] }}</p>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
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
                                @forelse ($countryCollectionSummary as $row)
                                    <tr class="border-b">
                                        <td class="py-2 pr-4">{{ $row['country_name'] }}</td>
                                        <td class="py-2 pr-4">{{ $row['expected'] }}</td>
                                        <td class="py-2 pr-4">{{ $row['actual'] }}</td>
                                        <td class="py-2">{{ $row['percentage'] }}%</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="py-4 text-gray-500">Aucune donnée disponible.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="rounded-lg bg-white p-6 shadow-sm">
                    <h3 class="mb-4 text-lg font-medium">Activité récente</h3>
                    <ul class="space-y-3 text-sm">
                        @forelse ($recentActivity as $activity)
                            <li class="border-b pb-2">
                                <p>{{ $activity['description'] }}</p>
                                <p class="text-gray-500">{{ $activity['occurred_at']->format('d/m/Y H:i') }}</p>
                            </li>
                        @empty
                            <li class="text-gray-500">Aucune activité récente.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-pahewo-layout>
