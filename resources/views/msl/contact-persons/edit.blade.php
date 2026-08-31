<x-msl-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Modifier le contact</h2></x-slot>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                <x-form-tip title="Personne de contact" :items="['Indiquez le nom complet.', 'Précisez l\'organisation et la fonction.', 'Ajoutez au moins un moyen de contact.']" />
                <form method="POST" action="{{ route('msl.contact-persons.update', $contactPerson) }}" class="space-y-4">
                    @csrf @method('PUT')
                    <div><x-input-label for="name" value="Nom *" /><x-text-input id="name" name="name" class="mt-1 block w-full" :value="old('name', $contactPerson->name)" required /></div>
                    <div><x-input-label for="organization" value="Organisation" /><x-text-input id="organization" name="organization" class="mt-1 block w-full" :value="old('organization', $contactPerson->organization)" /></div>
                    <div><x-input-label for="phone" value="Téléphone" /><x-text-input id="phone" name="phone" class="mt-1 block w-full" :value="old('phone', $contactPerson->phone)" /></div>
                    <div><x-input-label for="email" value="E-mail" /><x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $contactPerson->email)" /></div>
                    <x-primary-button>Mettre à jour</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-msl-layout>

