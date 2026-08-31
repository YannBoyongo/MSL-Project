<x-msl-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nouveau marché</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                @include('msl.partials.flash')

                <x-form-tip
                    title="Comment ajouter un marché ?"
                    :items="[
                        'Sélectionnez le pays.',
                        'Saisissez le nom officiel ou couramment utilisé du marché.',
                        'Indiquez la ville ou la localité.',
                        'Ajoutez l\'adresse lorsqu\'elle est connue.',
                        'Les coordonnées géographiques sont facultatives mais recommandées.',
                    ]"
                />

                <form method="POST" action="{{ route('msl.markets.store') }}" class="space-y-6">
                    @csrf
                    @include('msl.markets._form')
                    <div class="flex gap-3">
                        <x-primary-button>Enregistrer</x-primary-button>
                        <a href="{{ route('msl.markets.index') }}" class="inline-flex items-center rounded-md border px-4 py-2 text-sm">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-msl-layout>

