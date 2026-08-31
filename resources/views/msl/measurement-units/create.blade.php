<x-msl-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nouvelle unité de mesure</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                @include('msl.partials.flash')

                <x-form-tip
                    title="Comment ajouter une unité de mesure ?"
                    :items="[
                        'Le code identifie l\'unité dans le système (ex. kg, L).',
                        'Le symbole est affiché à côté des prix.',
                        'Saisissez le nom complet de l\'unité.',
                    ]"
                />

                <form method="POST" action="{{ route('msl.measurement-units.store') }}" class="mt-6 space-y-6">
                    @csrf
                    @include('msl.measurement-units._form')
                    <div class="flex gap-3">
                        <x-primary-button>Enregistrer</x-primary-button>
                        <a href="{{ route('msl.measurement-units.index') }}" class="inline-flex items-center rounded-md border px-4 py-2 text-sm">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-msl-layout>

