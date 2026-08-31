<x-msl-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Statistiques</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @include('msl.partials.flash')

            <div class="rounded-lg bg-white p-6 shadow-sm">
                @include('msl.partials.country-filter')
            </div>

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6">
                <div class="rounded-lg bg-white p-6 shadow-sm">
                    <p class="text-sm text-gray-500">Marchés actifs</p>
                    <p class="text-2xl font-semibold">{{ $marketCount }}</p>
                </div>
                <div class="rounded-lg bg-white p-6 shadow-sm">
                    <p class="text-sm text-gray-500">Prix du jour</p>
                    <p class="text-2xl font-semibold">{{ $todayPriceCount }}</p>
                </div>
                <div class="rounded-lg bg-white p-6 shadow-sm">
                    <p class="text-sm text-gray-500">Taux du jour</p>
                    <p class="text-2xl font-semibold">{{ $todayExchangeRateCount }}</p>
                </div>
                <div class="rounded-lg bg-white p-6 shadow-sm">
                    <p class="text-sm text-gray-500">Total prix</p>
                    <p class="text-2xl font-semibold">{{ $totalPrices }}</p>
                </div>
                <div class="rounded-lg bg-white p-6 shadow-sm">
                    <p class="text-sm text-gray-500">Total taux</p>
                    <p class="text-2xl font-semibold">{{ $totalRates }}</p>
                </div>
                <div class="rounded-lg bg-white p-6 shadow-sm">
                    <p class="text-sm text-gray-500">Réclamations</p>
                    <p class="text-2xl font-semibold">{{ $totalClaims }}</p>
                </div>
            </div>

            <div class="rounded-lg bg-white p-6 shadow-sm">
                <h3 class="mb-4 text-lg font-medium">Résumé de collecte par pays</h3>
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
                                <tr><td colspan="4" class="py-6 text-center text-gray-500">Aucune donnée disponible.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-msl-layout>

