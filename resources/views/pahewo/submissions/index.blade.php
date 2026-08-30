<x-pahewo-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Mes soumissions du jour</h2>
            <a href="{{ route('pahewo.submissions.history') }}" class="inline-flex items-center rounded-md border px-4 py-2 text-sm">Historique complet</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @include('pahewo.partials.flash')

            <div class="rounded-lg bg-white p-6 shadow-sm">
                <h3 class="mb-4 text-lg font-medium">Prix enregistrés aujourd'hui</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b text-left text-gray-500">
                                <th class="py-2 pr-4">Marché</th>
                                <th class="py-2 pr-4">Marchandise</th>
                                <th class="py-2 pr-4">Prix</th>
                                <th class="py-2 pr-4">Devise</th>
                                <th class="py-2 pr-4">Heure</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentPrices as $price)
                                <tr class="border-b">
                                    <td class="py-2 pr-4">{{ $price->market?->name }}</td>
                                    <td class="py-2 pr-4">{{ $price->commodity?->translate_name ?? $price->commodity?->code }}</td>
                                    <td class="py-2 pr-4">{{ number_format((float) $price->price, 2) }}</td>
                                    <td class="py-2 pr-4">{{ $price->currency?->code }}</td>
                                    <td class="py-2 pr-4">{{ $price->created_at?->format('H:i') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="py-6 text-center text-gray-500">Aucun prix enregistré aujourd'hui.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="rounded-lg bg-white p-6 shadow-sm">
                <h3 class="mb-4 text-lg font-medium">Taux enregistrés aujourd'hui</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b text-left text-gray-500">
                                <th class="py-2 pr-4">Pays</th>
                                <th class="py-2 pr-4">Paire</th>
                                <th class="py-2 pr-4">Taux</th>
                                <th class="py-2 pr-4">Heure</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentRates as $rate)
                                <tr class="border-b">
                                    <td class="py-2 pr-4">{{ $rate->country?->name }}</td>
                                    <td class="py-2 pr-4">{{ $rate->baseCurrency?->code }} / {{ $rate->quoteCurrency?->code }}</td>
                                    <td class="py-2 pr-4">{{ number_format((float) $rate->rate, 4) }}</td>
                                    <td class="py-2 pr-4">{{ $rate->created_at?->format('H:i') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="py-6 text-center text-gray-500">Aucun taux enregistré aujourd'hui.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-pahewo-layout>
