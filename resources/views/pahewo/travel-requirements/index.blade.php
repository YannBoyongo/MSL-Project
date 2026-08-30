<x-pahewo-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Exigences de voyage</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                @include('pahewo.partials.flash')
                @include('pahewo.partials.country-filter')

                @forelse ($documents as $countryName => $countryDocuments)
                    <div class="mb-8 last:mb-0">
                        <h3 class="mb-3 text-lg font-medium text-gray-800">{{ $countryName }}</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead>
                                    <tr class="border-b text-left text-gray-500">
                                        <th class="py-2 pr-4">Document</th>
                                        <th class="py-2 pr-4">Type</th>
                                        <th class="py-2 pr-4">Obligatoire</th>
                                        <th class="py-2 pr-4">Validité (jours)</th>
                                        <th class="py-2 pr-4">Frais</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($countryDocuments as $doc)
                                        <tr class="border-b">
                                            <td class="py-2 pr-4">{{ $doc->translate_name ?? '-' }}</td>
                                            <td class="py-2 pr-4">{{ $doc->documentType?->translate_name ?? $doc->documentType?->code ?? '-' }}</td>
                                            <td class="py-2 pr-4">{{ $doc->is_required ? 'Oui' : 'Non' }}</td>
                                            <td class="py-2 pr-4">{{ $doc->validity_days ?? '-' }}</td>
                                            <td class="py-2 pr-4">
                                                @if ($doc->fee)
                                                    {{ number_format((float) $doc->fee, 2) }} {{ $doc->feeCurrency?->code }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @empty
                    <p class="py-6 text-center text-gray-500">Aucune exigence de voyage enregistrée.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-pahewo-layout>
