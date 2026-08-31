<x-msl-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Modifier la réclamation</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                @include('msl.partials.flash')

                <x-form-tip
                    title="Examen de la réclamation"
                    :items="[
                        'Mettez à jour le statut selon l\'avancement du traitement.',
                        'Vérifiez que le titre et la description restent exacts.',
                        'Les modifications sont visibles par le demandeur.',
                    ]"
                />

                <form method="POST" action="{{ route('msl.claims.update', $claim) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="status" value="Statut *" />
                        <select id="status" name="status" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @foreach (App\Enums\ClaimStatus::cases() as $status)
                                <option value="{{ $status->value }}" @selected(old('status', $claim->status?->value) === $status->value)>{{ $status->label() }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-input-label for="title" value="Titre *" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $claim->title)" required />
                    </div>

                    <div>
                        <x-input-label for="description" value="Description *" />
                        <textarea id="description" name="description" rows="5" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('description', $claim->description) }}</textarea>
                    </div>

                    <div class="flex gap-3">
                        <x-primary-button>Mettre à jour</x-primary-button>
                        <a href="{{ route('msl.claims.show', $claim) }}" class="inline-flex items-center rounded-md border px-4 py-2 text-sm">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-msl-layout>

