<x-pahewo-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Enregistrer un taux de change</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                @include('pahewo.partials.flash')

                <x-form-tip
                    title="Comment enregistrer un taux de change ?"
                    :items="[
                        'Sélectionnez la devise de base.',
                        'Sélectionnez la devise de destination.',
                        'Exemple : 1 USD = 2 850 CDF.',
                        'Dans ce cas, USD est la devise de base et CDF la devise de destination.',
                        'Saisissez uniquement le taux observé.',
                        'Indiquez la source du taux si elle est connue.',
                        'Vérifiez la date avant d\'enregistrer.',
                    ]"
                />

                <form method="POST" action="{{ route('pahewo.exchange-rates.store') }}" class="space-y-4">
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

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <x-input-label for="base_currency_id" value="Devise de base *" />
                            <select id="base_currency_id" name="base_currency_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">Sélectionner</option>
                                @foreach ($currencies as $currency)
                                    <option value="{{ $currency->id }}" @selected(old('base_currency_id') == $currency->id)>{{ $currency->code }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('base_currency_id')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="quote_currency_id" value="Devise de destination *" />
                            <select id="quote_currency_id" name="quote_currency_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">Sélectionner</option>
                                @foreach ($currencies as $currency)
                                    <option value="{{ $currency->id }}" @selected(old('quote_currency_id') == $currency->id)>{{ $currency->code }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('quote_currency_id')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <x-input-label for="rate" value="Taux *" />
                            <x-text-input id="rate" name="rate" type="number" step="0.000001" class="mt-1 block w-full" :value="old('rate')" required />
                            <x-input-error :messages="$errors->get('rate')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="rate_date" value="Date *" />
                            <x-text-input id="rate_date" name="rate_date" type="date" class="mt-1 block w-full" :value="old('rate_date', now()->toDateString())" required />
                            <x-input-error :messages="$errors->get('rate_date')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="source" value="Source" />
                        <x-text-input id="source" name="source" type="text" class="mt-1 block w-full" :value="old('source')" />
                        <x-input-error :messages="$errors->get('source')" class="mt-2" />
                    </div>

                    <div class="flex gap-3">
                        <x-primary-button>Enregistrer</x-primary-button>
                        <a href="{{ route('pahewo.exchange-rates.index') }}" class="inline-flex items-center rounded-md border px-4 py-2 text-sm">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-pahewo-layout>
