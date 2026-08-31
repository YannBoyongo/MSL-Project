<x-msl-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Rapport des réclamations</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @include('msl.partials.flash')

            <div class="rounded-lg bg-white p-6 shadow-sm">
                @include('msl.partials.country-filter')
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                <div class="rounded-lg bg-white p-6 shadow-sm">
                    <h3 class="mb-4 text-lg font-medium">Par statut</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="border-b text-left text-gray-500">
                                    <th class="py-2 pr-4">Statut</th>
                                    <th class="py-2">Nombre</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($byStatus as $status => $count)
                                    <tr class="border-b">
                                        <td class="py-2 pr-4">
                                            @php
                                                $statusEnum = \App\Enums\ClaimStatus::tryFrom($status);
                                            @endphp
                                            {{ $statusEnum?->label() ?? $status }}
                                        </td>
                                        <td class="py-2">{{ $count }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="2" class="py-4 text-gray-500">Aucune réclamation.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="rounded-lg bg-white p-6 shadow-sm">
                    <h3 class="mb-4 text-lg font-medium">Par pays</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="border-b text-left text-gray-500">
                                    <th class="py-2 pr-4">Pays</th>
                                    <th class="py-2">Nombre</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($byCountry as $countryName => $count)
                                    <tr class="border-b">
                                        <td class="py-2 pr-4">{{ $countryName }}</td>
                                        <td class="py-2">{{ $count }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="2" class="py-4 text-gray-500">Aucune réclamation.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div>
                <a href="{{ route('msl.reports.index') }}" class="text-sm text-indigo-600 hover:underline">← Retour aux rapports</a>
            </div>
        </div>
    </div>
</x-msl-layout>

