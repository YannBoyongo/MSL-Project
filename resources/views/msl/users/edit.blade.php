<x-msl-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Modifier l'utilisateur</h2></x-slot>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                <x-form-tip title="Comment créer un utilisateur ?" :items="['Saisissez le nom complet.', 'Assignez uniquement les rôles nécessaires.', 'Sélectionnez les pays autorisés.']" />
                <form method="POST" action="{{ route('msl.users.update', $user) }}" class="space-y-4">
                    @csrf @method('PUT')
                    <div><x-input-label for="name" value="Nom *" /><x-text-input id="name" name="name" class="mt-1 block w-full" :value="old('name', $user->name)" required /></div>
                    <div><x-input-label for="email" value="E-mail *" /><x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required /></div>
                    <div><x-input-label for="password" value="Nouveau mot de passe" /><x-text-input id="password" name="password" type="password" class="mt-1 block w-full" /></div>
                    <div><x-input-label for="password_confirmation" value="Confirmer le mot de passe" /><x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" /></div>
                    <div>
                        <x-input-label value="Rôles" />
                        <div class="mt-2 space-y-1">@foreach($roles as $role)<label class="flex items-center gap-2"><input type="checkbox" name="roles[]" value="{{ $role->name }}" @checked(collect(old('roles', $user->roles->pluck('name')))->contains($role->name))> {{ $role->name }}</label>@endforeach</div>
                    </div>
                    <div>
                        <x-input-label value="Pays" />
                        <div class="mt-2 space-y-1">@foreach($countries as $country)<label class="flex items-center gap-2"><input type="checkbox" name="countries[]" value="{{ $country->id }}" @checked(collect(old('countries', $user->countries->pluck('id')))->contains($country->id))> {{ $country->name }}</label>@endforeach</div>
                    </div>
                    <x-primary-button>Mettre à jour</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-msl-layout>

