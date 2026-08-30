<x-pahewo-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Modifier l'unité de mesure</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                @include('pahewo.partials.flash')

                <x-form-tip
                    title="Comment modifier une unité de mesure ?"
                    :items="[
                        'Vérifiez que le code et le symbole restent cohérents.',
                        'Mettez à jour le nom si nécessaire.',
                        'Désactivez l\'unité si elle n\'est plus utilisée.',
                    ]"
                />

                <form method="POST" action="{{ route('pahewo.measurement-units.update', $measurementUnit) }}" class="mt-6 space-y-6">
                    @csrf
                    @method('PUT')
                    @include('pahewo.measurement-units._form', ['measurementUnit' => $measurementUnit, 'translation' => $translation])
                    <div class="flex gap-3">
                        <x-primary-button>Mettre à jour</x-primary-button>
                        <a href="{{ route('pahewo.measurement-units.index') }}" class="inline-flex items-center rounded-md border px-4 py-2 text-sm">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-pahewo-layout>
