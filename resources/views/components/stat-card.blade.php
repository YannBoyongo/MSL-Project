@props([
    'icon',
    'label',
    'value',
    'trend' => null,
    'trendDirection' => null,
])

@php
    $trendClasses = match ($trendDirection) {
        'up' => 'text-emerald-600',
        'down' => 'text-red-600',
        default => 'text-gray-500',
    };

    $trendSymbol = match ($trendDirection) {
        'up' => '↑',
        'down' => '↓',
        default => null,
    };
@endphp

<div {{ $attributes->merge(['class' => 'rounded-lg border border-gray-200 bg-white p-4 shadow-sm']) }}>
    <div class="flex items-start justify-between gap-3">
        <div class="min-w-0 flex-1">
            <p class="text-sm font-medium text-gray-500">{{ $label }}</p>
            <p class="mt-1 text-2xl font-semibold tabular-nums text-gray-900">{{ $value }}</p>
            @if ($trend)
                <p class="mt-1 text-xs font-medium {{ $trendClasses }}">
                    @if ($trendSymbol)
                        <span aria-hidden="true">{{ $trendSymbol }}</span>
                    @endif
                    {{ $trend }}
                </p>
            @endif
        </div>
        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gray-50 text-lg" aria-hidden="true">
            {{ $icon }}
        </span>
    </div>
</div>
