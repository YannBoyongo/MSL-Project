<x-msl-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nouveau bureau de change</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                @include('msl.partials.flash')

                <x-form-tip
                    title="Comment ajouter un bureau de change ?"
                    :items="[
                        'Sélectionnez le pays où se trouve le bureau.',
                        'Saisissez le nom officiel ou couramment utilisé.',
                        'Indiquez la ville et l\'adresse si connues.',
                        'Ajoutez le numéro de téléphone pour faciliter les contacts.',
                    ]"
                />

                <form method="POST" action="{{ route('msl.forex-bureaus.store') }}" class="mt-6 space-y-6">
                    @csrf
                    @include('msl.forex-bureaus._form')
                    <div class="flex gap-3">
                        <x-primary-button>Enregistrer</x-primary-button>
                        <a href="{{ route('msl.forex-bureaus.index') }}" class="inline-flex items-center rounded-md border px-4 py-2 text-sm">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-msl-layout>

