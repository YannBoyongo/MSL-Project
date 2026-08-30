<x-pahewo-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Prix journaliers</h2>
            @can('create', App\Models\CommodityPrice::class)
                <a href="{{ route('pahewo.commodity-prices.create') }}" class="inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-sm text-white">Enregistrer un prix</a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                @include('pahewo.partials.flash')
                @include('pahewo.partials.country-filter')

                <form method="GET" class="mb-4 flex flex-wrap items-end gap-3">
                    <x-query-hidden-fields :except="['price_date', 'page']" />
                    <div>
                        <x-input-label for="price_date" value="Date" />
                        <x-text-input id="price_date" name="price_date" type="date" class="mt-1 block" :value="$priceDate" />
                    </div>
                    <x-primary-button type="submit">Filtrer</x-primary-button>
                    <a href="{{ route('pahewo.commodity-prices.index', ['country_id' => $countryId, 'price_date' => '']) }}" class="self-center text-sm text-gray-600 hover:underline">Toutes les dates</a>
                </form>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b text-left text-gray-500">
                                <th class="py-2 pr-4">Date</th>
                                <th class="py-2 pr-4">Marché</th>
                                <th class="py-2 pr-4">Marchandise</th>
                                <th class="py-2 pr-4">Prix</th>
                                <th class="py-2 pr-4">Devise</th>
                                <th class="py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($prices as $price)
                                <tr class="border-b">
                                    <td class="py-2 pr-4">{{ $price->price_date?->format('d/m/Y') }}</td>
                                    <td class="py-2 pr-4">{{ $price->market?->name }}</td>
                                    <td class="py-2 pr-4">{{ $price->commodity?->translate_name ?? $price->commodity?->code }}</td>
                                    <td class="py-2 pr-4">{{ number_format((float) $price->price, 2) }}</td>
                                    <td class="py-2 pr-4">{{ $price->currency?->code }}</td>
                                    <td class="py-2">
                                        @can('update', $price)
                                            <a href="{{ route('pahewo.commodity-prices.edit', $price) }}" class="text-indigo-600 hover:underline">Modifier</a>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="py-6 text-center text-gray-500">Aucun prix enregistré.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">{{ $prices->links() }}</div>
            </div>
        </div>
    </div>
</x-pahewo-layout>
