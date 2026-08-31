<x-msl-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Langue préférée</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                @include('msl.partials.flash')

                <x-form-tip
                    title="Comment choisir sa langue ?"
                    :items="[
                        'Sélectionnez la langue dans laquelle vous souhaitez consulter les contenus traduits.',
                        'Votre choix s\'applique aux noms de marchandises, catégories et documents.',
                        'Vous pouvez modifier cette préférence à tout moment.',
                    ]"
                />

                <form method="POST" action="{{ route('msl.language.update') }}" class="mt-6 space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="preferred_language_id" value="Langue *" />
                        <select id="preferred_language_id" name="preferred_language_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">Sélectionner une langue</option>
                            @foreach ($languages as $language)
                                <option value="{{ $language->id }}" @selected(old('preferred_language_id', auth()->user()->preferred_language_id) == $language->id)>
                                    {{ $language->name }} ({{ $language->code }})
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('preferred_language_id')" class="mt-2" />
                    </div>

                    <x-primary-button>Enregistrer</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-msl-layout>

