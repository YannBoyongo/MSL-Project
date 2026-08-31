<x-msl-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Modifier la catégorie</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                @include('msl.partials.flash')

                <x-form-tip
                    title="Comment modifier une catégorie ?"
                    :items="[
                        'Vérifiez que le code reste cohérent avec les marchandises associées.',
                        'Mettez à jour le nom et la description si nécessaire.',
                        'Désactivez la catégorie si elle n\'est plus utilisée.',
                    ]"
                />

                <form method="POST" action="{{ route('msl.commodity-categories.update', $commodityCategory) }}" class="mt-6 space-y-6">
                    @csrf
                    @method('PUT')
                    @include('msl.commodity-categories._form', ['commodityCategory' => $commodityCategory, 'translation' => $translation])
                    <div class="flex gap-3">
                        <x-primary-button>Mettre à jour</x-primary-button>
                        <a href="{{ route('msl.commodity-categories.index') }}" class="inline-flex items-center rounded-md border px-4 py-2 text-sm">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-msl-layout>

