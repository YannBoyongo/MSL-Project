@php
    use Illuminate\Support\Facades\Route;

    $menu = config('pahewo.menu', []);
@endphp

<aside
    {{ $attributes->merge(['class' => 'flex h-full w-[250px] shrink-0 flex-col border-r border-gray-200 bg-white']) }}
>
    <div class="flex h-14 items-center border-b border-gray-200 px-4">
        <a href="{{ route('dashboard') }}" class="text-lg font-bold tracking-tight text-indigo-700">
            {{ __('pahewo.app_name') }}
        </a>
    </div>

    <nav class="flex-1 overflow-y-auto pb-4" aria-label="{{ __('pahewo.common.menu') }}">
        @foreach ($menu as $section)
            @php
                $visibleItems = collect($section['items'])->filter(function (array $item): bool {
                    if ($item['permission'] === null) {
                        return true;
                    }

                    return auth()->user()?->can($item['permission']) ?? false;
                });
            @endphp

            @if ($visibleItems->isNotEmpty())
                <x-sidebar-section :title="__('pahewo.sections.'.$section['section'])">
                    @foreach ($visibleItems as $item)
                        @php
                            $href = Route::has($item['route'])
                                ? route($item['route'])
                                : '#';
                        @endphp

                        <x-sidebar-link
                            :href="$href"
                            :icon="$item['icon']"
                            :label="__('pahewo.'.$item['label'])"
                            :active="$item['active'] ?? null"
                        />
                    @endforeach
                </x-sidebar-section>
            @endif
        @endforeach
    </nav>

    <div class="border-t border-gray-200 p-3">
        <div class="rounded-md bg-gray-50 px-3 py-2">
            <p class="truncate text-sm font-medium text-gray-900">{{ auth()->user()?->name }}</p>
            <p class="truncate text-xs text-gray-500">{{ auth()->user()?->email }}</p>
        </div>
    </div>
</aside>
