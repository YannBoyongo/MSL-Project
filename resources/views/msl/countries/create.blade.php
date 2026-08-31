<x-msl-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Nouveau pays</h2></x-slot>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                <x-form-tip title="Configuration d'un pays" :items="['Saisissez le nom officiel du pays.', 'Utilisez le code ISO à deux lettres.', 'Indiquez le préfixe téléphonique si connu.']" />
                <form method="POST" action="{{ route('msl.countries.store') }}" class="space-y-4">
                    @csrf
                    <div><x-input-label for="name" value="Nom *" /><x-text-input id="name" name="name" class="mt-1 block w-full" :value="old('name')" required /></div>
                    <div><x-input-label for="iso_code" value="Code ISO *" /><x-text-input id="iso_code" name="iso_code" maxlength="2" class="mt-1 block w-full" :value="old('iso_code')" required /></div>
                    <div><x-input-label for="phone_code" value="Indicatif téléphonique" /><x-text-input id="phone_code" name="phone_code" class="mt-1 block w-full" :value="old('phone_code')" /></div>
                    <label class="flex items-center gap-2"><input type="checkbox" name="is_active" value="1" checked> Actif</label>
                    <x-primary-button>Enregistrer</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-msl-layout>

