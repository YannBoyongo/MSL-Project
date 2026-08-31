@php
    $measurementUnit = $measurementUnit ?? null;
    $translation = $translation ?? null;
@endphp

<div class="space-y-4">
    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <x-input-label for="code" value="Code *" />
            <x-text-input id="code" name="code" type="text" class="mt-1 block w-full" :value="old('code', $measurementUnit->code ?? '')" required />
            <x-input-error :messages="$errors->get('code')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="symbol" value="Symbole *" />
            <x-text-input id="symbol" name="symbol" type="text" class="mt-1 block w-full" :value="old('symbol', $measurementUnit->symbol ?? '')" required />
            <x-input-error :messages="$errors->get('symbol')" class="mt-2" />
        </div>
    </div>

    <div>
        <x-input-label for="name" value="Nom *" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', optional($translation)->name)" required />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <div class="flex items-center gap-2">
        <input id="is_active" name="is_active" type="checkbox" value="1" @checked(old('is_active', $measurementUnit->is_active ?? true)) class="rounded border-gray-300">
        <x-input-label for="is_active" value="Unité active" />
    </div>
</div>
