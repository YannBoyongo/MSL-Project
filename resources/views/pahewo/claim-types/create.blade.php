<x-pahewo-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nouveau type de réclamation</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                @include('pahewo.partials.flash')

                <x-form-tip
                    title="Comment ajouter un type de réclamation ?"
                    :items="[
                        'Le code doit être unique et descriptif.',
                        'Saisissez le nom affiché aux utilisateurs.',
                        'La description précise quand utiliser ce type.',
                    ]"
                />

                <form method="POST" action="{{ route('pahewo.claim-types.store') }}" class="mt-6 space-y-6">
                    @csrf
                    @include('pahewo.claim-types._form')
                    <div class="flex gap-3">
                        <x-primary-button>Enregistrer</x-primary-button>
                        <a href="{{ route('pahewo.claim-types.index') }}" class="inline-flex items-center rounded-md border px-4 py-2 text-sm">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-pahewo-layout>
