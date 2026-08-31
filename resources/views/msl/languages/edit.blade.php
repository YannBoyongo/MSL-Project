<x-msl-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Modifier la langue</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                @include('msl.partials.flash')

                <x-form-tip
                    title="Comment modifier une langue ?"
                    :items="[
                        'Le code identifie la langue dans le système.',
                        'Désactivez la langue si elle ne doit plus être proposée.',
                    ]"
                />

                <form method="POST" action="{{ route('msl.languages.update', $language) }}" class="mt-6 space-y-6">
                    @csrf
                    @method('PUT')
                    @include('msl.languages._form', ['language' => $language])
                    <div class="flex gap-3">
                        <x-primary-button>Mettre à jour</x-primary-button>
                        <a href="{{ route('msl.languages.index') }}" class="inline-flex items-center rounded-md border px-4 py-2 text-sm">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-msl-layout>

