@php
    $language = $language ?? null;
@endphp

<div class="space-y-4">
    <div>
        <x-input-label for="code" value="Code *" />
        <x-text-input id="code" name="code" type="text" maxlength="5" class="mt-1 block w-full" :value="old('code', $language->code ?? '')" required />
        <x-input-error :messages="$errors->get('code')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="name" value="Nom *" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $language->name ?? '')" required />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <div class="flex items-center gap-2">
        <input id="is_active" name="is_active" type="checkbox" value="1" @checked(old('is_active', $language->is_active ?? true)) class="rounded border-gray-300">
        <x-input-label for="is_active" value="Langue active" />
    </div>
</div>
