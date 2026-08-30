<x-pahewo-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Enregistrer un prix</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                @include('pahewo.partials.flash')

                <x-form-tip
                    title="Comment enregistrer un prix ?"
                    :items="[
                        'Sélectionnez le marché où le prix a été observé.',
                        'Choisissez la marchandise concernée.',
                        'Saisissez le prix tel qu\'il est vendu sur le marché.',
                        'Sélectionnez la devise utilisée.',
                        'Ne convertissez pas manuellement le prix dans une autre devise.',
                        'Vérifiez l\'unité de mesure.',
                        'Vérifiez la date de collecte.',
                    ]"
                />

                <form method="POST" action="{{ route('pahewo.commodity-prices.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <x-input-label for="market_id" value="Marché *" />
                        <select id="market_id" name="market_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">Sélectionner un marché</option>
                            @foreach ($markets as $market)
                                <option value="{{ $market->id }}" @selected(old('market_id') == $market->id)>{{ $market->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('market_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="commodity_id" value="Marchandise *" />
                        <select id="commodity_id" name="commodity_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">Sélectionner une marchandise</option>
                            @foreach ($commodities as $commodity)
                                <option value="{{ $commodity->id }}" @selected(old('commodity_id') == $commodity->id)>
                                    {{ $commodity->translate_name ?? $commodity->code }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('commodity_id')" class="mt-2" />
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <x-input-label for="price" value="Prix *" />
                            <x-text-input id="price" name="price" type="number" step="0.0001" class="mt-1 block w-full" :value="old('price')" required />
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="currency_id" value="Devise *" />
                            <select id="currency_id" name="currency_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">Sélectionner une devise</option>
                                @foreach ($currencies as $currency)
                                    <option value="{{ $currency->id }}" @selected(old('currency_id') == $currency->id)>{{ $currency->code }} - {{ $currency->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('currency_id')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="price_date" value="Date du prix *" />
                        <x-text-input id="price_date" name="price_date" type="date" class="mt-1 block w-full" :value="old('price_date', now()->toDateString())" required />
                        <x-input-error :messages="$errors->get('price_date')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="notes" value="Notes" />
                        <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('notes') }}</textarea>
                        <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                    </div>

                    <div class="flex gap-3">
                        <x-primary-button>Enregistrer</x-primary-button>
                        <a href="{{ route('pahewo.commodity-prices.index') }}" class="inline-flex items-center rounded-md border px-4 py-2 text-sm">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-pahewo-layout>
