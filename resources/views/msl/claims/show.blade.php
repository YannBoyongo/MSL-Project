<x-msl-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Réclamation {{ $claim->reference_number }}</h2>
            <a href="{{ route('msl.claims.index') }}" class="text-sm text-gray-600 hover:underline">Retour à la liste</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @include('msl.partials.flash')

            <div class="rounded-lg bg-white p-6 shadow-sm">
                <div class="mb-6 flex flex-wrap items-center gap-3">
                    <span class="rounded-full bg-gray-100 px-3 py-1 text-sm">{{ $claim->status?->label() }}</span>
                    <span class="text-sm text-gray-500">Soumise le {{ $claim->submitted_at?->format('d/m/Y H:i') ?? $claim->created_at?->format('d/m/Y H:i') }}</span>
                </div>

                <dl class="grid gap-4 sm:grid-cols-2 text-sm">
                    <div>
                        <dt class="font-medium text-gray-500">Titre</dt>
                        <dd>{{ $claim->title }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-500">Pays</dt>
                        <dd>{{ $claim->country?->name }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-500">Type</dt>
                        <dd>{{ $claim->claimType?->translate_name ?? $claim->claimType?->code }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-500">Demandeur</dt>
                        <dd>{{ $claim->user?->name }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="font-medium text-gray-500">Description</dt>
                        <dd class="mt-1 whitespace-pre-wrap">{{ $claim->description }}</dd>
                    </div>
                </dl>
            </div>

            <div class="rounded-lg bg-white p-6 shadow-sm">
                <h3 class="mb-4 text-lg font-medium">Historique du statut</h3>
                <ol class="relative border-l border-gray-200 pl-6">
                    @forelse ($claim->statusHistories->sortBy('created_at') as $history)
                        <li class="mb-6 ml-2">
                            <span class="absolute -left-1.5 mt-1.5 h-3 w-3 rounded-full border border-white bg-indigo-500"></span>
                            <p class="font-medium">{{ $history->status?->label() }}</p>
                            <p class="text-sm text-gray-600">{{ $history->comment }}</p>
                            <p class="text-xs text-gray-400">
                                {{ $history->created_at?->format('d/m/Y H:i') }}
                                @if ($history->changedBy)
                                    - {{ $history->changedBy->name }}
                                @endif
                            </p>
                        </li>
                    @empty
                        <li class="text-gray-500">Aucun historique disponible.</li>
                    @endforelse
                </ol>
            </div>
        </div>
    </div>
</x-msl-layout>

