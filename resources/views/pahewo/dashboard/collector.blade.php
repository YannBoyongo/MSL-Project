<x-pahewo-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tableau de bord - Collecteur</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @include('pahewo.partials.flash')

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <a href="{{ route('pahewo.commodity-prices.create') }}" class="rounded-lg bg-white p-6 shadow-sm hover:bg-gray-50">
                    <p class="font-semibold">Enregistrer un prix</p>
                    <p class="text-sm text-gray-500">Saisir un nouveau prix journalier</p>
                </a>
                <a href="{{ route('pahewo.commodity-prices.index') }}" class="rounded-lg bg-white p-6 shadow-sm hover:bg-gray-50">
                    <p class="font-semibold">Prix du jour</p>
                    <p class="text-sm text-gray-500">{{ $todayPriceCount }} prix enregistrés aujourd'hui</p>
                </a>
                <a href="{{ route('pahewo.exchange-rates.create') }}" class="rounded-lg bg-white p-6 shadow-sm hover:bg-gray-50">
                    <p class="font-semibold">Enregistrer un taux</p>
                    <p class="text-sm text-gray-500">Saisir un taux de change</p>
                </a>
            </div>

            <div class="rounded-lg bg-white p-6 shadow-sm">
                <h3 class="mb-4 text-lg font-medium">Progression de collecte</h3>
                <p class="text-3xl font-semibold">{{ $priceCollectionCompletion['percentage'] }}%</p>
                <p class="text-sm text-gray-500">{{ $priceCollectionCompletion['actual'] }} / {{ $priceCollectionCompletion['expected'] }} prix attendus</p>
            </div>
        </div>
    </div>
</x-pahewo-layout>
