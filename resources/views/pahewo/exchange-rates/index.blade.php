<x-pahewo-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Taux de change</h2>
            @can('exchange_rates.create')
                <a href="{{ route('pahewo.exchange-rates.create') }}" class="inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-sm text-white">Enregistrer un taux</a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                @include('pahewo.partials.flash')
                @include('pahewo.partials.country-filter')

                <form method="GET" class="mb-4 flex flex-wrap items-end gap-3">
                    <x-query-hidden-fields :except="['rate_date', 'page']" />
                    <div>
                        <x-input-label for="rate_date" value="Date" />
                        <x-text-input id="rate_date" name="rate_date" type="date" class="mt-1 block" :value="$rateDate" />
                    </div>
                    <x-primary-button type="submit">Filtrer</x-primary-button>
                    <a href="{{ route('pahewo.exchange-rates.index', ['country_id' => $countryId, 'rate_date' => '']) }}" class="self-center text-sm text-gray-600 hover:underline">Toutes les dates</a>
                </form>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b text-left text-gray-500">
                                <th class="py-2 pr-4">Date</th>
                                <th class="py-2 pr-4">Pays</th>
                                <th class="py-2 pr-4">Paire</th>
                                <th class="py-2 pr-4">Taux</th>
                                <th class="py-2 pr-4">Source</th>
                                <th class="py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($exchangeRates as $rate)
                                <tr class="border-b">
                                    <td class="py-2 pr-4">{{ $rate->rate_date?->format('d/m/Y') }}</td>
                                    <td class="py-2 pr-4">{{ $rate->country?->name }}</td>
                                    <td class="py-2 pr-4">{{ $rate->baseCurrency?->code }} / {{ $rate->quoteCurrency?->code }}</td>
                                    <td class="py-2 pr-4">{{ number_format((float) $rate->rate, 4) }}</td>
                                    <td class="py-2 pr-4">{{ $rate->source ?? '-' }}</td>
                                    <td class="py-2">
                                        @can('exchange_rates.update')
                                            <a href="{{ route('pahewo.exchange-rates.edit', $rate) }}" class="text-indigo-600 hover:underline">Modifier</a>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="py-6 text-center text-gray-500">Aucun taux enregistré.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">{{ $exchangeRates->links() }}</div>
            </div>
        </div>
    </div>
</x-pahewo-layout>
