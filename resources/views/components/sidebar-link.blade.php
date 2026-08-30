@props([
    'href',
    'icon',
    'label',
    'active' => null,
])

@php
    $isActive = $active
        ? request()->routeIs($active)
        : url()->current() === $href;
@endphp

<a
    href="{{ $href }}"
    @class([
        'flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium transition',
        'bg-indigo-50 text-indigo-700' => $isActive,
        'text-gray-600 hover:bg-gray-50 hover:text-gray-900' => ! $isActive,
    ])
    @if ($isActive) aria-current="page" @endif
    {{ $attributes }}
>
    <span class="w-5 shrink-0 text-center text-base leading-none" aria-hidden="true">{{ $icon }}</span>
    <span class="truncate">{{ $label }}</span>
</a>
