<x-pahewo-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tableau de bord - Commerçant</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @include('pahewo.partials.flash')

            <div class="grid gap-4 sm:grid-cols-1 md:grid-cols-3">
                <a href="{{ route('pahewo.commodity-prices.index') }}" class="rounded-lg bg-white p-6 shadow-sm hover:bg-gray-50">
                    <p class="text-lg font-semibold">Prix du jour</p>
                    <p class="text-sm text-gray-500">Consulter les prix du marché</p>
                </a>
                <a href="{{ route('pahewo.exchange-rates.index') }}" class="rounded-lg bg-white p-6 shadow-sm hover:bg-gray-50">
                    <p class="text-lg font-semibold">Taux de change</p>
                    <p class="text-sm text-gray-500">Consulter les taux du jour</p>
                </a>
                <a href="{{ route('pahewo.claims.create') }}" class="rounded-lg bg-white p-6 shadow-sm hover:bg-gray-50">
                    <p class="text-lg font-semibold">Soumettre une réclamation</p>
                    <p class="text-sm text-gray-500">Signaler un problème</p>
                </a>
            </div>

            <div class="rounded-lg bg-white p-6 shadow-sm">
                <h3 class="mb-4 text-lg font-medium">Derniers taux de change</h3>
                <ul class="space-y-2 text-sm">
                    @forelse ($latestExchangeRates as $rate)
                        <li class="flex justify-between border-b pb-2">
                            <span>{{ $rate->baseCurrency?->code }} / {{ $rate->quoteCurrency?->code }}</span>
                            <span>{{ number_format((float) $rate->rate, 2) }}</span>
                        </li>
                    @empty
                        <li class="text-gray-500">Aucun taux disponible.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-pahewo-layout>
