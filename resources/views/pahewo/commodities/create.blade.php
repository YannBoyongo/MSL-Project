<x-pahewo-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nouvelle marchandise</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                @include('pahewo.partials.flash')

                <x-form-tip
                    title="Comment ajouter une marchandise ?"
                    :items="[
                        'Sélectionnez la catégorie appropriée.',
                        'Choisissez l\'unité de mesure utilisée sur les marchés.',
                        'Le code doit être unique et facilement identifiable.',
                        'Saisissez le nom dans la langue courante.',
                        'La description aide les collecteurs à identifier le produit.',
                    ]"
                />

                <form method="POST" action="{{ route('pahewo.commodities.store') }}" class="mt-6 space-y-6">
                    @csrf
                    @include('pahewo.commodities._form')
                    <div class="flex gap-3">
                        <x-primary-button>Enregistrer</x-primary-button>
                        <a href="{{ route('pahewo.commodities.index') }}" class="inline-flex items-center rounded-md border px-4 py-2 text-sm">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-pahewo-layout>
