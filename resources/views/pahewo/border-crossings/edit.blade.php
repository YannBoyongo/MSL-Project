<x-pahewo-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Modifier le poste frontalier</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                @include('pahewo.partials.flash')

                <x-form-tip
                    title="Comment modifier un poste frontalier ?"
                    :items="[
                        'Mettez à jour le statut en cas de changement (fermeture temporaire, etc.).',
                        'Vérifiez les horaires d\'ouverture et de fermeture.',
                        'Désactivez le poste s\'il n\'est plus suivi.',
                    ]"
                />

                <form method="POST" action="{{ route('pahewo.border-crossings.update', $borderCrossing) }}" class="mt-6 space-y-6">
                    @csrf
                    @method('PUT')
                    @include('pahewo.border-crossings._form', ['borderCrossing' => $borderCrossing])
                    <div class="flex gap-3">
                        <x-primary-button>Mettre à jour</x-primary-button>
                        <a href="{{ route('pahewo.border-crossings.index') }}" class="inline-flex items-center rounded-md border px-4 py-2 text-sm">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-pahewo-layout>
