@props(['except' => ['page']])

@foreach (request()->except($except) as $key => $value)
    @if (is_array($value))
        @foreach ($value as $item)
            <input type="hidden" name="{{ $key }}[]" value="{{ $item }}">
        @endforeach
    @elseif ($value !== null && $value !== '')
        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
    @endif
@endforeach
