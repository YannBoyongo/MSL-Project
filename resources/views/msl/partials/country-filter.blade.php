@if (isset($countries) && $countries->isNotEmpty())
    <form method="GET" class="mb-4 flex flex-wrap items-end gap-3">
        <x-query-hidden-fields :except="['country_id', 'page']" />

        <div>
            <x-input-label for="country_id" value="Filtrer par pays" />
            <select id="country_id" name="country_id" class="mt-1 block rounded-md border-gray-300 shadow-sm">
                <option value="" @selected(($countryId ?? null) === null)>Tous les pays</option>
                @foreach ($countries as $country)
                    <option value="{{ $country->id }}" @selected(($countryId ?? null) == $country->id)>
                        {{ $country->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <x-primary-button type="submit">Appliquer</x-primary-button>
    </form>
@endif
