<x-msl-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Soumettre une réclamation</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                @include('msl.partials.flash')

                <x-form-tip
                    title="Comment soumettre une réclamation ?"
                    :items="[
                        'Choisissez le type de problème rencontré.',
                        'Indiquez le lieu où le problème s\'est produit.',
                        'Décrivez clairement ce qui s\'est passé.',
                        'Ajoutez la date de l\'incident si elle est connue.',
                        'Vous pouvez joindre des photos ou documents justificatifs.',
                        'Évitez de saisir des informations inutiles ou sans rapport avec la réclamation.',
                    ]"
                />

                <form method="POST" action="{{ route('msl.claims.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <x-input-label for="country_id" value="Pays *" />
                        <select id="country_id" name="country_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">Sélectionner un pays</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}" @selected(old('country_id', $countryId) == $country->id)>{{ $country->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('country_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="claim_type_id" value="Type de réclamation *" />
                        <select id="claim_type_id" name="claim_type_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">Sélectionner un type</option>
                            @foreach ($claimTypes as $type)
                                <option value="{{ $type->id }}" @selected(old('claim_type_id') == $type->id)>
                                    {{ $type->translate_name ?? $type->code }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('claim_type_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="title" value="Titre *" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title')" required />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="description" value="Description *" />
                        <textarea id="description" name="description" rows="5" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <x-input-label for="market_id" value="Marché" />
                            <select id="market_id" name="market_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">-</option>
                                @foreach ($markets as $market)
                                    <option value="{{ $market->id }}" @selected(old('market_id') == $market->id)>{{ $market->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="border_crossing_id" value="Poste frontalier" />
                            <select id="border_crossing_id" name="border_crossing_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">-</option>
                                @foreach ($borderCrossings as $crossing)
                                    <option value="{{ $crossing->id }}" @selected(old('border_crossing_id') == $crossing->id)>{{ $crossing->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <x-input-label for="occurred_at" value="Date de l'incident" />
                        <x-text-input id="occurred_at" name="occurred_at" type="datetime-local" class="mt-1 block w-full" :value="old('occurred_at')" />
                        <x-input-error :messages="$errors->get('occurred_at')" class="mt-2" />
                    </div>

                    <div class="flex gap-3">
                        <x-primary-button>Soumettre</x-primary-button>
                        <a href="{{ route('msl.claims.index') }}" class="inline-flex items-center rounded-md border px-4 py-2 text-sm">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-msl-layout>

