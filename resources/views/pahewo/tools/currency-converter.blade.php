<x-pahewo-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Convertisseur de devises</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                @include('pahewo.partials.flash')

                @include('pahewo.partials.country-filter')

                <x-form-tip
                    title="Comment utiliser le convertisseur ?"
                    :items="[
                        'Saisissez le montant à convertir.',
                        'Sélectionnez la devise source et la devise cible.',
                        'Le filtre par pays permet d\'utiliser les taux locaux.',
                        'La conversion utilise le taux le plus récent disponible.',
                    ]"
                />

                <form method="POST" action="{{ route('pahewo.currency-converter') }}" class="mt-6 space-y-4">
                    @csrf

                    <div>
                        <x-input-label for="amount" value="Montant *" />
                        <x-text-input id="amount" name="amount" type="number" step="0.01" min="0" class="mt-1 block w-full" :value="old('amount')" required />
                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <x-input-label for="from_currency_id" value="Devise source *" />
                            <select id="from_currency_id" name="from_currency_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">Sélectionner</option>
                                @foreach ($currencies as $currency)
                                    <option value="{{ $currency->id }}" @selected(old('from_currency_id') == $currency->id)>{{ $currency->code }} - {{ $currency->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('from_currency_id')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="to_currency_id" value="Devise cible *" />
                            <select id="to_currency_id" name="to_currency_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">Sélectionner</option>
                                @foreach ($currencies as $currency)
                                    <option value="{{ $currency->id }}" @selected(old('to_currency_id') == $currency->id)>{{ $currency->code }} - {{ $currency->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('to_currency_id')" class="mt-2" />
                        </div>
                    </div>

                    <x-primary-button>Convertir</x-primary-button>
                </form>

                @if ($error)
                    <div class="mt-6 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-800">
                        {{ $error }}
                    </div>
                @elseif ($result !== null)
                    <div class="mt-6 rounded-lg border border-green-200 bg-green-50 p-4">
                        <p class="text-sm text-green-800">Résultat de la conversion</p>
                        <p class="mt-1 text-2xl font-semibold text-green-900">{{ number_format($result, 4) }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-pahewo-layout>
