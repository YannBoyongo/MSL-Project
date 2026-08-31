<x-msl-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Utilisateurs</h2>
            @can('users.manage')
                <a href="{{ route('msl.users.create') }}" class="inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-sm text-white">Nouvel utilisateur</a>
            @endcan
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                @include('msl.partials.flash')
                @include('msl.partials.country-filter')

                <x-search-filter placeholder="Rechercher par nom ou e-mail..." />

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead><tr class="border-b text-left text-gray-500"><th class="py-2 pr-4">Nom</th><th class="py-2 pr-4">E-mail</th><th class="py-2 pr-4">Rôles</th><th class="py-2">Actions</th></tr></thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr class="border-b">
                                    <td class="py-2 pr-4">{{ $user->name }}</td>
                                    <td class="py-2 pr-4">{{ $user->email }}</td>
                                    <td class="py-2 pr-4">{{ $user->roles->pluck('name')->join(', ') }}</td>
                                    <td class="py-2">@can('users.manage')<a href="{{ route('msl.users.edit', $user) }}" class="text-indigo-600 hover:underline">Modifier</a>@endcan</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="py-6 text-center text-gray-500">Aucun utilisateur.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $users->links() }}</div>
            </div>
        </div>
    </div>
</x-msl-layout>

