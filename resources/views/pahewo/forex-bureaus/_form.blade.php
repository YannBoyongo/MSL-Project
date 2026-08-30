@php
    $forexBureau = $forexBureau ?? null;
@endphp

<div class="space-y-4">
    <div>
        <x-input-label for="country_id" value="Pays *" />
        <select id="country_id" name="country_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            <option value="">Sélectionner un pays</option>
            @foreach ($countries as $country)
                <option value="{{ $country->id }}" @selected(old('country_id', $forexBureau->country_id ?? null) == $country->id)>
                    {{ $country->name }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('country_id')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="name" value="Nom *" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $forexBureau->name ?? '')" required />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="city" value="Ville *" />
        <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city', $forexBureau->city ?? '')" required />
        <x-input-error :messages="$errors->get('city')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="address" value="Adresse" />
        <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $forexBureau->address ?? '')" />
        <x-input-error :messages="$errors->get('address')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="phone" value="Téléphone" />
        <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $forexBureau->phone ?? '')" />
        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
    </div>

    <div class="flex items-center gap-2">
        <input id="is_active" name="is_active" type="checkbox" value="1" @checked(old('is_active', $forexBureau->is_active ?? true)) class="rounded border-gray-300">
        <x-input-label for="is_active" value="Bureau actif" />
    </div>
</div>
