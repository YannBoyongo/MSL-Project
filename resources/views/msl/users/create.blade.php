<x-msl-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Nouvel utilisateur</h2></x-slot>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                <x-form-tip title="Comment créer un utilisateur ?" :items="['Saisissez le nom complet de l\'utilisateur.', 'Utilisez une adresse e-mail ou un numéro de téléphone valide.', 'Assignez uniquement les rôles nécessaires.', 'Sélectionnez le ou les pays auxquels l\'utilisateur peut accéder.', 'Sélectionnez les marchés assignés lorsque cela est nécessaire.']" />
                <form method="POST" action="{{ route('msl.users.store') }}" class="space-y-4">
                    @csrf
                    <div><x-input-label for="name" value="Nom *" /><x-text-input id="name" name="name" class="mt-1 block w-full" :value="old('name')" required /></div>
                    <div><x-input-label for="email" value="E-mail *" /><x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required /></div>
                    <div><x-input-label for="password" value="Mot de passe *" /><x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required /></div>
                    <div><x-input-label for="password_confirmation" value="Confirmer le mot de passe *" /><x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" required /></div>
                    <div>
                        <x-input-label value="Rôles" />
                        <div class="mt-2 space-y-1">@foreach($roles as $role)<label class="flex items-center gap-2"><input type="checkbox" name="roles[]" value="{{ $role->name }}" @checked(collect(old('roles', []))->contains($role->name))> {{ $role->name }}</label>@endforeach</div>
                    </div>
                    <div>
                        <x-input-label value="Pays" />
                        <div class="mt-2 space-y-1">@foreach($countries as $country)<label class="flex items-center gap-2"><input type="checkbox" name="countries[]" value="{{ $country->id }}" @checked(collect(old('countries', []))->contains($country->id))> {{ $country->name }}</label>@endforeach</div>
                    </div>
                    <x-primary-button>Enregistrer</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-msl-layout>

