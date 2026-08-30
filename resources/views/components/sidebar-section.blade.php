@props([
    'title',
])

<div {{ $attributes->merge(['class' => 'px-3 pt-4 first:pt-2']) }}>
    <p class="mb-1 px-3 text-xs font-semibold uppercase tracking-wide text-gray-400">
        {{ $title }}
    </p>
    <div class="space-y-0.5">
        {{ $slot }}
    </div>
</div>
