<x-pahewo-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Rôles et permissions</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @include('pahewo.partials.flash')

            <div class="rounded-lg bg-white p-6 shadow-sm">
                <h3 class="mb-4 text-lg font-medium">Rôles</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b text-left text-gray-500">
                                <th class="py-2 pr-4">Rôle</th>
                                <th class="py-2 pr-4">Permissions</th>
                                <th class="py-2 pr-4">Utilisateurs</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($roles as $role)
                                <tr class="border-b">
                                    <td class="py-2 pr-4 font-medium">{{ $role->name }}</td>
                                    <td class="py-2 pr-4">{{ $role->permissions_count }}</td>
                                    <td class="py-2 pr-4">{{ $role->users_count }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="py-6 text-center text-gray-500">Aucun rôle configuré.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="rounded-lg bg-white p-6 shadow-sm">
                <h3 class="mb-4 text-lg font-medium">Permissions par module</h3>
                <div class="space-y-6">
                    @foreach ($permissions as $module => $modulePermissions)
                        <div>
                            <h4 class="mb-2 text-sm font-semibold uppercase text-gray-600">{{ $module }}</h4>
                            <ul class="grid gap-2 sm:grid-cols-2 lg:grid-cols-3 text-sm text-gray-700">
                                @foreach ($modulePermissions as $permission)
                                    <li class="rounded border px-3 py-2">{{ $permission->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-pahewo-layout>
