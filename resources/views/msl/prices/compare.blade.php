<x-msl-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Comparaison des prix</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                @include('msl.partials.flash')

                <form method="GET" class="mb-6 flex flex-wrap items-end gap-3">
                    <x-query-hidden-fields :except="['commodity_id', 'date', 'country_id', 'page']" />
                    <div>
                        <x-input-label for="commodity_id" value="Marchandise" />
                        <select id="commodity_id" name="commodity_id" class="mt-1 block rounded-md border-gray-300 shadow-sm">
                            <option value="">Sélectionner une marchandise</option>
                            @foreach ($commodities as $commodity)
                                <option value="{{ $commodity->id }}" @selected($commodityId == $commodity->id)>
                                    {{ $commodity->translate_name ?? $commodity->code }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <x-input-label for="date" value="Date" />
                        <x-text-input id="date" name="date" type="date" class="mt-1 block" :value="$date" />
                    </div>
                    <div>
                        <x-input-label for="country_id" value="Pays" />
                        <select id="country_id" name="country_id" class="mt-1 block rounded-md border-gray-300 shadow-sm">
                            <option value="">Tous les pays</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}" @selected($countryId == $country->id)>{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <x-primary-button type="submit">Comparer</x-primary-button>
                </form>

                @if ($commodityId)
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="border-b text-left text-gray-500">
                                    <th class="py-2 pr-4">Marché</th>
                                    <th class="py-2 pr-4">Pays</th>
                                    <th class="py-2 pr-4">Prix</th>
                                    <th class="py-2 pr-4">Devise</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($prices as $price)
                                    <tr class="border-b">
                                        <td class="py-2 pr-4">{{ $price->market?->name }}</td>
                                        <td class="py-2 pr-4">{{ $price->market?->country?->name }}</td>
                                        <td class="py-2 pr-4">{{ number_format((float) $price->price, 2) }}</td>
                                        <td class="py-2 pr-4">{{ $price->currency?->code }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="py-6 text-center text-gray-500">Aucun prix trouvé pour cette sélection.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center text-gray-500">Sélectionnez une marchandise pour comparer les prix entre marchés.</p>
                @endif
            </div>
        </div>
    </div>
</x-msl-layout>

