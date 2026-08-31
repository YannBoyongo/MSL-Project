<x-msl-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Modifier la devise</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                @include('msl.partials.flash')

                <x-form-tip
                    title="Comment modifier une devise ?"
                    :items="[
                        'Vérifiez le code ISO avant de modifier.',
                        'Ajustez le nombre de décimales selon les usages locaux.',
                        'Désactivez la devise si elle n\'est plus utilisée.',
                    ]"
                />

                <form method="POST" action="{{ route('msl.currencies.update', $currency) }}" class="mt-6 space-y-6">
                    @csrf
                    @method('PUT')
                    @include('msl.currencies._form', ['currency' => $currency])
                    <div class="flex gap-3">
                        <x-primary-button>Mettre à jour</x-primary-button>
                        <a href="{{ route('msl.currencies.index') }}" class="inline-flex items-center rounded-md border px-4 py-2 text-sm">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-msl-layout>

