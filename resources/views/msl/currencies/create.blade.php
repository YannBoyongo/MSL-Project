<x-msl-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nouvelle devise</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                @include('msl.partials.flash')

                <x-form-tip
                    title="Comment ajouter une devise ?"
                    :items="[
                        'Utilisez le code ISO à trois lettres (ex. USD, CDF).',
                        'Indiquez le symbole monétaire si applicable.',
                        'Le nombre de décimales détermine l\'affichage des montants.',
                    ]"
                />

                <form method="POST" action="{{ route('msl.currencies.store') }}" class="mt-6 space-y-6">
                    @csrf
                    @include('msl.currencies._form')
                    <div class="flex gap-3">
                        <x-primary-button>Enregistrer</x-primary-button>
                        <a href="{{ route('msl.currencies.index') }}" class="inline-flex items-center rounded-md border px-4 py-2 text-sm">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-msl-layout>

