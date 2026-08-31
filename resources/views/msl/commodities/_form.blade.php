@php
    $commodity = $commodity ?? null;
    $translation = $translation ?? null;
@endphp

<div class="space-y-4">
    <div>
        <x-input-label for="commodity_category_id" value="Catégorie *" />
        <select id="commodity_category_id" name="commodity_category_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            <option value="">Sélectionner une catégorie</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('commodity_category_id', $commodity->commodity_category_id ?? null) == $category->id)>
                    {{ $category->translate_name ?? $category->code }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('commodity_category_id')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="measurement_unit_id" value="Unité de mesure *" />
        <select id="measurement_unit_id" name="measurement_unit_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            <option value="">Sélectionner une unité</option>
            @foreach ($units as $unit)
                <option value="{{ $unit->id }}" @selected(old('measurement_unit_id', $commodity->measurement_unit_id ?? null) == $unit->id)>
                    {{ $unit->translate_name ?? $unit->code }} ({{ $unit->symbol }})
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('measurement_unit_id')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="code" value="Code *" />
        <x-text-input id="code" name="code" type="text" class="mt-1 block w-full" :value="old('code', $commodity->code ?? '')" required />
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
        <input id="is_active" name="is_active" type="checkbox" value="1" @checked(old('is_active', $commodity->is_active ?? true)) class="rounded border-gray-300">
        <x-input-label for="is_active" value="Marchandise active" />
    </div>
</div>
