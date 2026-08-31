<x-msl-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Paramètres de l'application</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                @include('msl.partials.flash')

                <p class="text-sm text-gray-600">
                    Cette section accueillera prochainement la configuration globale de l'application MSL
                    (paramètres régionaux, notifications, intégrations, etc.).
                </p>

                <div class="mt-6 rounded-lg border border-dashed border-gray-300 p-8 text-center text-gray-500">
                    <p class="text-sm">Configuration à venir</p>
                </div>
            </div>
        </div>
    </div>
</x-msl-layout>

