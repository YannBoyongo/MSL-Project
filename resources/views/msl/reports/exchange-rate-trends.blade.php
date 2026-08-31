<x-msl-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tendances des taux de change</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                @include('msl.partials.flash')

                <form method="GET" class="mb-6 flex flex-wrap items-end gap-3">
                    <x-query-hidden-fields :except="['days', 'country_id', 'page']" />
                    <div>
                        <x-input-label for="days" value="Période (jours)" />
                        <x-text-input id="days" name="days" type="number" min="7" max="365" class="mt-1 block w-32" :value="$days" />
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
                    <x-primary-button type="submit">Appliquer</x-primary-button>
                </form>

                @forelse ($trends as $pair => $rates)
                    <div class="mb-8 last:mb-0">
                        <h3 class="mb-3 text-lg font-medium text-gray-800">{{ $pair }}</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead>
                                    <tr class="border-b text-left text-gray-500">
                                        <th class="py-2 pr-4">Date</th>
                                        <th class="py-2 pr-4">Taux</th>
                                        <th class="py-2 pr-4">Source</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rates as $rate)
                                        <tr class="border-b">
                                            <td class="py-2 pr-4">{{ $rate->rate_date?->format('d/m/Y') }}</td>
                                            <td class="py-2 pr-4">{{ number_format((float) $rate->rate, 4) }}</td>
                                            <td class="py-2 pr-4">{{ $rate->source ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @empty
                    <p class="py-6 text-center text-gray-500">Aucune donnée pour cette période.</p>
                @endforelse

                <div class="mt-4">
                    <a href="{{ route('msl.reports.index') }}" class="text-sm text-indigo-600 hover:underline">← Retour aux rapports</a>
                </div>
            </div>
        </div>
    </div>
</x-msl-layout>

