@props([
    'type' => 'success',
    'message' => null,
    'dismissible' => true,
])

@php
    $styles = match ($type) {
        'success' => 'border-emerald-200 bg-emerald-50 text-emerald-800',
        'error' => 'border-red-200 bg-red-50 text-red-800',
        'warning' => 'border-amber-200 bg-amber-50 text-amber-800',
        'info' => 'border-sky-200 bg-sky-50 text-sky-800',
        default => 'border-gray-200 bg-gray-50 text-gray-800',
    };

    $icons = [
        'success' => '✓',
        'error' => '✕',
        'warning' => '⚠',
        'info' => 'ℹ',
    ];
@endphp

<div
    x-data="{ show: true }"
    x-show="show"
    x-transition
    {{ $attributes->merge(['class' => "rounded-lg border px-4 py-3 text-sm {$styles}"]) }}
    role="alert"
>
    <div class="flex items-start gap-3">
        <span class="font-semibold" aria-hidden="true">{{ $icons[$type] ?? '•' }}</span>
        <div class="flex-1">
            {{ $message ?? $slot }}
        </div>
        @if ($dismissible)
            <button
                type="button"
                class="shrink-0 opacity-60 transition hover:opacity-100"
                @click="show = false"
                aria-label="{{ __('pahewo.common.close') }}"
            >
                ✕
            </button>
        @endif
    </div>
</div>
