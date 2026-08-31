@props([
    'title' => __('msl.empty.title'),
    'description' => __('msl.empty.description'),
    'icon' => '📭',
])

<div {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center rounded-lg border border-dashed border-gray-300 bg-white px-6 py-12 text-center']) }}>
    <span class="text-3xl" aria-hidden="true">{{ $icon }}</span>
    <h3 class="mt-3 text-sm font-semibold text-gray-900">{{ $title }}</h3>
    <p class="mt-1 max-w-sm text-sm text-gray-500">{{ $description }}</p>

    @isset($action)
        <div class="mt-4">
            {{ $action }}
        </div>
    @endisset
</div>
