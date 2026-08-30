@props([
    'countries' => collect(),
    'selected' => null,
    'name' => 'country_id',
    'action' => null,
    'showAll' => true,
])

<form
    method="GET"
    action="{{ $action ?? url()->current() }}"
    {{ $attributes->merge(['class' => 'inline-flex items-center gap-2']) }}
>
    @foreach (request()->except($name, 'page') as $key => $value)
        @if (is_array($value))
            @foreach ($value as $item)
                <input type="hidden" name="{{ $key }}[]" value="{{ $item }}">
            @endforeach
        @else
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endif
    @endforeach

    <label for="{{ $name }}" class="text-sm font-medium text-gray-600">
        {{ __('pahewo.common.country') }} :
    </label>

    <select
        id="{{ $name }}"
        name="{{ $name }}"
        onchange="this.form.submit()"
        class="rounded-md border-gray-300 bg-white py-1.5 pl-3 pr-8 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
    >
        @if ($showAll)
            <option value="" @selected($selected === null || $selected === '')>
                {{ __('pahewo.common.all_countries') }}
            </option>
        @endif

        @foreach ($countries as $country)
            <option value="{{ $country->id }}" @selected((string) $selected === (string) $country->id)>
                {{ $country->name }}
            </option>
        @endforeach
    </select>
</form>
