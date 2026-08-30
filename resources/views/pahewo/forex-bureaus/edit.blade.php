<x-pahewo-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Modifier le bureau de change</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                @include('pahewo.partials.flash')

                <x-form-tip
                    title="Comment modifier un bureau de change ?"
                    :items="[
                        'Vérifiez que le pays correspond à la localisation du bureau.',
                        'Mettez à jour l\'adresse et le téléphone si nécessaire.',
                        'Désactivez le bureau s\'il n\'est plus opérationnel.',
                    ]"
                />

                <form method="POST" action="{{ route('pahewo.forex-bureaus.update', $forexBureau) }}" class="mt-6 space-y-6">
                    @csrf
                    @method('PUT')
                    @include('pahewo.forex-bureaus._form', ['forexBureau' => $forexBureau])
                    <div class="flex gap-3">
                        <x-primary-button>Mettre à jour</x-primary-button>
                        <a href="{{ route('pahewo.forex-bureaus.index') }}" class="inline-flex items-center rounded-md border px-4 py-2 text-sm">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-pahewo-layout>
