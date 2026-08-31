@php
    $currency = $currency ?? null;
@endphp

<div class="space-y-4">
    <div>
        <x-input-label for="code" value="Code ISO *" />
        <x-text-input id="code" name="code" type="text" maxlength="3" class="mt-1 block w-full uppercase" :value="old('code', $currency->code ?? '')" required />
        <x-input-error :messages="$errors->get('code')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="name" value="Nom *" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $currency->name ?? '')" required />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <x-input-label for="symbol" value="Symbole" />
            <x-text-input id="symbol" name="symbol" type="text" class="mt-1 block w-full" :value="old('symbol', $currency->symbol ?? '')" />
            <x-input-error :messages="$errors->get('symbol')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="decimal_places" value="Décimales *" />
            <x-text-input id="decimal_places" name="decimal_places" type="number" min="0" max="4" class="mt-1 block w-full" :value="old('decimal_places', $currency->decimal_places ?? 2)" required />
            <x-input-error :messages="$errors->get('decimal_places')" class="mt-2" />
        </div>
    </div>

    <div class="flex items-center gap-2">
        <input id="is_active" name="is_active" type="checkbox" value="1" @checked(old('is_active', $currency->is_active ?? true)) class="rounded border-gray-300">
        <x-input-label for="is_active" value="Devise active" />
    </div>
</div>
