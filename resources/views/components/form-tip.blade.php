@props([
    'title' => __('Comment remplir ce formulaire ?'),
    'items' => [],
])

<div {{ $attributes->merge(['class' => 'rounded-lg border border-sky-200 bg-sky-50 p-4 sm:p-5']) }}>
    <div class="flex gap-3">
        <span class="text-lg leading-none text-sky-600" aria-hidden="true">💡</span>
        <div class="min-w-0 flex-1">
            <h3 class="text-sm font-semibold text-sky-900">{{ $title }}</h3>
            @if (count($items) > 0)
                <ul class="mt-2 space-y-1.5 text-sm text-sky-800">
                    @foreach ($items as $item)
                        <li class="flex gap-2">
                            <span class="text-sky-500" aria-hidden="true">•</span>
                            <span>{{ $item }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                {{ $slot }}
            @endif
        </div>
    </div>
</div>
