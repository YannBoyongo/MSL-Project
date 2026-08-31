{{--
    Expected variables from controller:
    - $userName (string)
    - $selectedMarket (?object with name)
    - $selectedCountry (?object with name)
    - $todayPriceCount (int)
    - $todayExchangeRateCount (int)
    - $collectionProgress (array: percentage)
    - $priceProgress (array: actual, expected, percentage)
    - $rateProgress (array: actual, expected, percentage)
    - $remainingPriceCount (int)
    - $missingItems (list of strings)
    - $recentSubmissions (list of arrays: label, value, status)
    - $activityStats (array: today, week, month)
--}}
<x-msl-layout :title="__('msl.dashboard.title')">
    <x-page-header
        :title="__('msl.dashboard.title')"
        :subtitle="__('msl.common.welcome', ['name' => $userName ?? auth()->user()->name])"
    >
        <x-slot name="actions">
            <span class="text-sm text-gray-500">📅 {{ now()->translatedFormat('j F Y') }}</span>
        </x-slot>
    </x-page-header>

    <div class="mb-4 flex flex-wrap items-center gap-4 text-sm text-gray-600">
        @if ($selectedMarket ?? null)
            <span>{{ __('msl.common.market') }} : <strong class="text-gray-900">{{ $selectedMarket->name }}</strong></span>
        @endif
        @if ($selectedCountry ?? null)
            <span>{{ __('msl.common.country') }} : <strong class="text-gray-900">{{ $selectedCountry->name }}</strong></span>
        @endif
    </div>

    {{-- Stat cards --}}
    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
        <x-stat-card
            icon="📦"
            :label="__('msl.dashboard.prices_today')"
            :value="number_format($todayPriceCount ?? 0)"
        >
        </x-stat-card>
        <x-stat-card
            icon="💱"
            :label="__('msl.dashboard.rates_today')"
            :value="number_format($todayExchangeRateCount ?? 0)"
        />
        <x-stat-card
            icon="✅"
            :label="__('msl.dashboard.progress')"
            :value="number_format($collectionProgress['percentage'] ?? 0, 0).' %'"
        />
    </div>

    {{-- Collection progress --}}
    <section class="mb-6 rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500">
                {{ __('msl.dashboard.daily_collection') }}
            </h2>
            <span class="text-sm font-semibold text-gray-900">
                {{ number_format($collectionProgress['percentage'] ?? 0, 0) }} %
            </span>
        </div>

        <div class="mb-5 h-2.5 w-full overflow-hidden rounded-full bg-gray-100">
            <div
                class="h-full rounded-full bg-indigo-600"
                style="width: {{ min(100, $collectionProgress['percentage'] ?? 0) }}%"
            ></div>
        </div>

        <div class="space-y-3 text-sm">
            <div class="flex items-center justify-between">
                <span class="text-gray-600">{{ __('msl.dashboard.commodity_prices') }}</span>
                <span class="tabular-nums font-medium text-gray-900">
                    {{ $priceProgress['actual'] ?? 0 }} / {{ $priceProgress['expected'] ?? 0 }}
                    ({{ number_format($priceProgress['percentage'] ?? 0, 0) }} %)
                </span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-gray-600">{{ __('msl.dashboard.exchange_rate_collection') }}</span>
                <span class="tabular-nums font-medium text-gray-900">
                    {{ $rateProgress['actual'] ?? 0 }} / {{ $rateProgress['expected'] ?? 0 }}
                    ({{ number_format($rateProgress['percentage'] ?? 0, 0) }} %)
                </span>
            </div>
        </div>

        @if (($remainingPriceCount ?? 0) > 0)
            <p class="mt-4 rounded-md bg-amber-50 px-3 py-2 text-sm text-amber-800">
                ⚠ {{ __('msl.dashboard.remaining_prices', ['count' => $remainingPriceCount]) }}
            </p>
        @endif
    </section>

    <div class="mb-6 grid grid-cols-1 gap-6 lg:grid-cols-2">
        {{-- Quick actions --}}
        <section class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
            <h2 class="mb-4 text-sm font-semibold uppercase tracking-wide text-gray-500">
                {{ __('msl.dashboard.quick_actions') }}
            </h2>
            <div class="space-y-2">
                @can('prices.create')
                    <a href="{{ Route::has('msl.commodity-prices.create') ? route('msl.commodity-prices.create') : '#' }}" class="flex items-center gap-2 rounded-md border border-gray-200 px-4 py-3 text-sm font-medium text-gray-700 transition hover:bg-gray-50">
                        <span aria-hidden="true">➕</span> {{ __('msl.nav.record_price') }}
                    </a>
                @endcan
                @can('exchange_rates.create')
                    <a href="{{ Route::has('msl.exchange-rates.create') ? route('msl.exchange-rates.create') : '#' }}" class="flex items-center gap-2 rounded-md border border-gray-200 px-4 py-3 text-sm font-medium text-gray-700 transition hover:bg-gray-50">
                        <span aria-hidden="true">➕</span> {{ __('msl.nav.record_exchange_rate') }}
                    </a>
                @endcan
                <a href="{{ Route::has('msl.submissions.index') ? route('msl.submissions.index') : '#' }}" class="flex items-center gap-2 rounded-md border border-gray-200 px-4 py-3 text-sm font-medium text-gray-700 transition hover:bg-gray-50">
                    <span aria-hidden="true">📋</span> {{ __('msl.nav.my_submissions') }}
                </a>
            </div>
        </section>

        {{-- Missing data --}}
        <section class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
            <h2 class="mb-4 text-sm font-semibold uppercase tracking-wide text-gray-500">
                {{ __('msl.dashboard.missing_data') }}
            </h2>

            @if (! empty($missingItems))
                <ul class="space-y-2 text-sm">
                    @foreach ($missingItems as $item)
                        <li class="flex items-center gap-2 rounded-md bg-amber-50 px-3 py-2 text-amber-800">
                            <span aria-hidden="true">⚠</span>
                            <span>{{ is_array($item) ? ($item['name'] ?? '') : $item }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <x-empty-state icon="✅" :title="__('msl.common.no_data')" class="py-6" />
            @endif
        </section>
    </div>

    {{-- Latest submissions --}}
    <section class="mb-6 rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
        <h2 class="mb-4 text-sm font-semibold uppercase tracking-wide text-gray-500">
            {{ __('msl.dashboard.latest_submissions') }}
        </h2>

        @if (! empty($recentSubmissions))
            <ul class="divide-y divide-gray-100">
                @foreach ($recentSubmissions as $submission)
                    <li class="flex items-center justify-between gap-4 py-3 text-sm">
                        <div>
                            <span class="font-medium text-gray-900">{{ $submission['label'] ?? '' }}</span>
                            <span class="ml-2 text-gray-600">{{ $submission['value'] ?? '' }}</span>
                        </div>
                        <span class="shrink-0 text-emerald-600">✓ {{ $submission['status'] ?? __('msl.dashboard.recorded') }}</span>
                    </li>
                @endforeach
            </ul>
        @else
            <x-empty-state class="py-6" />
        @endif
    </section>

    {{-- Activity stats --}}
    <section class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
        <h2 class="mb-4 text-sm font-semibold uppercase tracking-wide text-gray-500">
            {{ __('msl.dashboard.my_activity') }}
        </h2>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div class="rounded-md bg-gray-50 px-4 py-3 text-center">
                <p class="text-xs uppercase tracking-wide text-gray-500">{{ __('msl.common.today') }}</p>
                <p class="mt-1 text-xl font-semibold tabular-nums text-gray-900">{{ $activityStats['today'] ?? 0 }}</p>
                <p class="text-xs text-gray-500">{{ __('msl.dashboard.submissions') }}</p>
            </div>
            <div class="rounded-md bg-gray-50 px-4 py-3 text-center">
                <p class="text-xs uppercase tracking-wide text-gray-500">{{ __('msl.dashboard.this_week') }}</p>
                <p class="mt-1 text-xl font-semibold tabular-nums text-gray-900">{{ $activityStats['week'] ?? 0 }}</p>
                <p class="text-xs text-gray-500">{{ __('msl.dashboard.submissions') }}</p>
            </div>
            <div class="rounded-md bg-gray-50 px-4 py-3 text-center">
                <p class="text-xs uppercase tracking-wide text-gray-500">{{ __('msl.dashboard.this_month') }}</p>
                <p class="mt-1 text-xl font-semibold tabular-nums text-gray-900">{{ $activityStats['month'] ?? 0 }}</p>
                <p class="text-xs text-gray-500">{{ __('msl.dashboard.submissions') }}</p>
            </div>
        </div>
    </section>
</x-msl-layout>
