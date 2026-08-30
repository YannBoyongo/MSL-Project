<form method="GET" {{ $attributes->merge(['class' => 'mb-4 flex flex-wrap items-end gap-3']) }}>
    <x-query-hidden-fields :except="array_merge(['search', 'page'], $except ?? [])" />

    <div class="min-w-[200px] flex-1">
        <x-input-label for="search" value="Rechercher" />
        <x-text-input
            id="search"
            name="search"
            type="search"
            class="mt-1 block w-full"
            placeholder="{{ $placeholder ?? 'Rechercher...' }}"
            :value="request('search')"
        />
    </div>

    {{ $slot }}

    <x-primary-button type="submit">Rechercher</x-primary-button>
</form>
