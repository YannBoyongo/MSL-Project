{{--
    Expected variables from controller (all optional):
    - $recentPrices (Collection)
    - $exchangeRateSummary (array)
    - $recentClaims (Collection)
--}}
<x-pahewo-layout :title="__('pahewo.dashboard.title')">
    <x-page-header
        :title="__('pahewo.dashboard.title')"
        :subtitle="__('pahewo.common.welcome', ['name' => auth()->user()->name])"
    />

    {{-- Main action cards --}}
    <div class="mb-8 grid grid-cols-1 gap-4 md:grid-cols-3">
        <a
            href="{{ Route::has('pahewo.prices.index') ? route('pahewo.prices.index') : '#' }}"
            class="group rounded-lg border border-gray-200 bg-white p-6 shadow-sm transition hover:border-indigo-300 hover:shadow-md"
        >
            <span class="text-3xl" aria-hidden="true">💰</span>
            <h2 class="mt-3 text-lg font-semibold text-gray-900 group-hover:text-indigo-700">
                {{ __('pahewo.trader.daily_prices_title') }}
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                {{ __('pahewo.trader.daily_prices_desc') }}
            </p>
        </a>

        <a
            href="{{ Route::has('pahewo.exchange-rates.index') ? route('pahewo.exchange-rates.index') : '#' }}"
            class="group rounded-lg border border-gray-200 bg-white p-6 shadow-sm transition hover:border-indigo-300 hover:shadow-md"
        >
            <span class="text-3xl" aria-hidden="true">💱</span>
            <h2 class="mt-3 text-lg font-semibold text-gray-900 group-hover:text-indigo-700">
                {{ __('pahewo.trader.exchange_rates_title') }}
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                {{ __('pahewo.trader.exchange_rates_desc') }}
            </p>
        </a>

        @can('claims.create')
            <a
                href="{{ Route::has('pahewo.claims.create') ? route('pahewo.claims.create') : '#' }}"
                class="group rounded-lg border border-gray-200 bg-white p-6 shadow-sm transition hover:border-indigo-300 hover:shadow-md"
            >
                <span class="text-3xl" aria-hidden="true">📝</span>
                <h2 class="mt-3 text-lg font-semibold text-gray-900 group-hover:text-indigo-700">
                    {{ __('pahewo.trader.submit_claim_title') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    {{ __('pahewo.trader.submit_claim_desc') }}
                </p>
            </a>
        @endcan
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        {{-- Recent prices --}}
        <section class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500">
                    {{ __('pahewo.nav.daily_prices') }}
                </h2>
                <a href="{{ Route::has('pahewo.prices.index') ? route('pahewo.prices.index') : '#' }}" class="text-xs font-medium text-indigo-600 hover:text-indigo-800">
                    {{ __('pahewo.common.view_all') }}
                </a>
            </div>

            @if (($recentPrices ?? collect())->isNotEmpty())
                <ul class="divide-y divide-gray-100 text-sm">
                    @foreach ($recentPrices as $price)
                        <li class="flex items-center justify-between py-3">
                            <span class="font-medium text-gray-900">{{ $price['label'] ?? '' }}</span>
                            <span class="tabular-nums text-gray-600">{{ $price['value'] ?? '' }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <x-empty-state class="py-6" />
            @endif
        </section>

        {{-- Exchange rate summary --}}
        <section class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500">
                    {{ __('pahewo.nav.exchange_rates') }}
                </h2>
                <a href="{{ Route::has('pahewo.exchange-rates.index') ? route('pahewo.exchange-rates.index') : '#' }}" class="text-xs font-medium text-indigo-600 hover:text-indigo-800">
                    {{ __('pahewo.common.view_all') }}
                </a>
            </div>

            @if (! empty($exchangeRateSummary))
                <ul class="divide-y divide-gray-100 text-sm">
                    @foreach ($exchangeRateSummary as $rate)
                        <li class="flex items-center justify-between py-3">
                            <span class="font-medium text-gray-900">{{ $rate['pair'] ?? '' }}</span>
                            <span class="tabular-nums text-gray-600">{{ $rate['value'] ?? '' }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <x-empty-state icon="💱" class="py-6" />
            @endif
        </section>
    </div>

    {{-- Recent claims --}}
    @can('claims.view')
        <section class="mt-6 rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500">
                    {{ __('pahewo.nav.claims') }}
                </h2>
                <a href="{{ Route::has('pahewo.claims.index') ? route('pahewo.claims.index') : '#' }}" class="text-xs font-medium text-indigo-600 hover:text-indigo-800">
                    {{ __('pahewo.common.view_all') }}
                </a>
            </div>

            @if (($recentClaims ?? collect())->isNotEmpty())
                <ul class="divide-y divide-gray-100">
                    @foreach ($recentClaims as $claim)
                        <li class="flex items-center justify-between gap-4 py-3 text-sm">
                            <div>
                                <span class="font-medium text-gray-900">{{ $claim->reference_number ?? $claim['reference_number'] ?? '' }}</span>
                                <span class="ml-2 text-gray-500">{{ $claim->title ?? $claim['title'] ?? '' }}</span>
                            </div>
                            @if ($claim->status ?? ($claim['status'] ?? null))
                                <x-status-badge :status="$claim->status ?? $claim['status']" />
                            @endif
                        </li>
                    @endforeach
                </ul>
            @else
                <x-empty-state icon="📝" class="py-6" />
            @endif
        </section>
    @endcan
</x-pahewo-layout>
