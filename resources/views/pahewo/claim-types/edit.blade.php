<x-pahewo-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Modifier le type de réclamation</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                @include('pahewo.partials.flash')

                <x-form-tip
                    title="Comment modifier un type de réclamation ?"
                    :items="[
                        'Vérifiez que le code reste cohérent avec les réclamations existantes.',
                        'Mettez à jour le nom et la description si nécessaire.',
                        'Désactivez le type s\'il n\'est plus proposé.',
                    ]"
                />

                <form method="POST" action="{{ route('pahewo.claim-types.update', $claimType) }}" class="mt-6 space-y-6">
                    @csrf
                    @method('PUT')
                    @include('pahewo.claim-types._form', ['claimType' => $claimType, 'translation' => $translation])
                    <div class="flex gap-3">
                        <x-primary-button>Mettre à jour</x-primary-button>
                        <a href="{{ route('pahewo.claim-types.index') }}" class="inline-flex items-center rounded-md border px-4 py-2 text-sm">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-pahewo-layout>
