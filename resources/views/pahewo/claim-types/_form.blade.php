@php
    $claimType = $claimType ?? null;
    $translation = $translation ?? null;
@endphp

<div class="space-y-4">
    <div>
        <x-input-label for="code" value="Code *" />
        <x-text-input id="code" name="code" type="text" class="mt-1 block w-full" :value="old('code', $claimType->code ?? '')" required />
        <x-input-error :messages="$errors->get('code')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="name" value="Nom *" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', optional($translation)->name)" required />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="description" value="Description" />
        <textarea id="description" name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('description', optional($translation)->description) }}</textarea>
        <x-input-error :messages="$errors->get('description')" class="mt-2" />
    </div>

    <div class="flex items-center gap-2">
        <input id="is_active" name="is_active" type="checkbox" value="1" @checked(old('is_active', $claimType->is_active ?? true)) class="rounded border-gray-300">
        <x-input-label for="is_active" value="Type actif" />
    </div>
</div>
