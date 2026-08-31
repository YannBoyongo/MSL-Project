@php
    $borderCrossing = $borderCrossing ?? null;
@endphp

<div class="space-y-4">
    <div>
        <x-input-label for="name" value="Nom *" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $borderCrossing->name ?? '')" required />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <x-input-label for="country_a_id" value="Pays A *" />
            <select id="country_a_id" name="country_a_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <option value="">Sélectionner un pays</option>
                @foreach ($countries as $country)
                    <option value="{{ $country->id }}" @selected(old('country_a_id', $borderCrossing->country_a_id ?? null) == $country->id)>
                        {{ $country->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('country_a_id')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="country_b_id" value="Pays B *" />
            <select id="country_b_id" name="country_b_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <option value="">Sélectionner un pays</option>
                @foreach ($countries as $country)
                    <option value="{{ $country->id }}" @selected(old('country_b_id', $borderCrossing->country_b_id ?? null) == $country->id)>
                        {{ $country->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('country_b_id')" class="mt-2" />
        </div>
    </div>

    <div>
        <x-input-label for="status" value="Statut *" />
        <select id="status" name="status" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            <option value="">Sélectionner un statut</option>
            @foreach ($statuses as $status)
                <option value="{{ $status->value }}" @selected(old('status', isset($borderCrossing) ? $borderCrossing->status?->value : null) == $status->value)>
                    {{ $status->label() }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('status')" class="mt-2" />
    </div>

    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <x-input-label for="opening_time" value="Heure d'ouverture" />
            <x-text-input id="opening_time" name="opening_time" type="time" class="mt-1 block w-full" :value="old('opening_time', isset($borderCrossing) && $borderCrossing->opening_time ? substr($borderCrossing->opening_time, 0, 5) : '')" />
            <x-input-error :messages="$errors->get('opening_time')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="closing_time" value="Heure de fermeture" />
            <x-text-input id="closing_time" name="closing_time" type="time" class="mt-1 block w-full" :value="old('closing_time', isset($borderCrossing) && $borderCrossing->closing_time ? substr($borderCrossing->closing_time, 0, 5) : '')" />
            <x-input-error :messages="$errors->get('closing_time')" class="mt-2" />
        </div>
    </div>

    <div class="flex items-center gap-2">
        <input id="is_active" name="is_active" type="checkbox" value="1" @checked(old('is_active', $borderCrossing->is_active ?? true)) class="rounded border-gray-300">
        <x-input-label for="is_active" value="Poste actif" />
    </div>
</div>
