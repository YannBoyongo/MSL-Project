<x-msl-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Personnes de contact</h2>
            <a href="{{ route('msl.contact-persons.create') }}" class="inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-sm text-white">Nouveau contact</a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                @include('msl.partials.flash')
                @include('msl.partials.country-filter')
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead><tr class="border-b text-left text-gray-500"><th class="py-2 pr-4">Nom</th><th class="py-2 pr-4">Organisation</th><th class="py-2 pr-4">Téléphone</th><th class="py-2">Actions</th></tr></thead>
                        <tbody>
                            @forelse ($contactPersons as $person)
                                <tr class="border-b">
                                    <td class="py-2 pr-4">{{ $person->name }}</td>
                                    <td class="py-2 pr-4">{{ $person->organization ?? '-' }}</td>
                                    <td class="py-2 pr-4">{{ $person->phone ?? '-' }}</td>
                                    <td class="py-2"><a href="{{ route('msl.contact-persons.edit', $person) }}" class="text-indigo-600 hover:underline">Modifier</a></td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="py-6 text-center text-gray-500">Aucun contact.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $contactPersons->links() }}</div>
            </div>
        </div>
    </div>
</x-msl-layout>

