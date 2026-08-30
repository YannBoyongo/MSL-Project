{{--
    Expected variables from DashboardService / controller:
    - $marketCount (int)
    - $todayPriceCount (int)
    - $todayExchangeRateCount (int)
    - $collectionProgress (array: expected, actual, percentage)
    - $countrySummary (list of country collection arrays)
    - $exchangeRates (Collection of ExchangeRate with baseCurrency, quoteCurrency)
    - $claimSummary (array: total, unresolved, by_status)
    - $recentActivity (Collection)
    - $countries (Collection)
    - $selectedCountryId (?int)
    - $attentionItems (optional list of ['message' => string])
--}}
<x-pahewo-layout :title="__('pahewo.dashboard.title')">
    <x-slot name="toolbar">
        <x-country-selector
            :countries="$countries ?? collect()"
            :selected="$selectedCountryId ?? request('country_id')"
        />
    </x-slot>

    <x-page-header
        :title="__('pahewo.dashboard.title')"
        :subtitle="now()->translatedFormat('l j F Y')"
    />

    {{-- Stat cards --}}
    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <x-stat-card
            icon="🏪"
            :label="__('pahewo.dashboard.markets')"
            :value="number_format($marketCount ?? 0)"
        />
        <x-stat-card
            icon="💰"
            :label="__('pahewo.dashboard.prices_today')"
            :value="number_format($todayPriceCount ?? 0)"
        />
        <x-stat-card
            icon="💱"
            :label="__('pahewo.dashboard.rates_today')"
            :value="number_format($todayExchangeRateCount ?? 0)"
        />
        <x-stat-card
            icon="📝"
            :label="__('pahewo.dashboard.unresolved_claims')"
            :value="number_format($claimSummary['unresolved'] ?? 0)"
        />
    </div>

    {{-- Collection progress --}}
    <section class="mb-6 rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
        <div class="mb-4 flex items-center justify-between gap-4">
            <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500">
                {{ __('pahewo.dashboard.daily_collection') }}
            </h2>
            <span class="text-sm font-semibold text-gray-900">
                {{ number_format($collectionProgress['percentage'] ?? 0, 0) }} %
            </span>
        </div>

        <div class="h-2.5 w-full overflow-hidden rounded-full bg-gray-100">
            <div
                class="h-full rounded-full bg-indigo-600 transition-all"
                style="width: {{ min(100, $collectionProgress['percentage'] ?? 0) }}%"
            ></div>
        </div>

        @if (! empty($countrySummary))
            <div class="mt-5 space-y-3">
                @foreach ($countrySummary as $country)
                    <div>
                        <div class="mb-1 flex items-center justify-between text-sm">
                            <span class="font-medium text-gray-700">{{ $country['country_name'] }}</span>
                            <span class="tabular-nums text-gray-600">
                                {{ number_format($country['percentage'], 0) }} %
                                @if ($country['percentage'] < 75)
                                    <span class="text-amber-500" aria-hidden="true">⚠</span>
                                @endif
                            </span>
                        </div>
                        <div class="h-2 w-full overflow-hidden rounded-full bg-gray-100">
                            <div
                                class="h-full rounded-full {{ $country['percentage'] < 75 ? 'bg-amber-500' : 'bg-emerald-500' }}"
                                style="width: {{ min(100, $country['percentage']) }}%"
                            ></div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    <div class="mb-6 grid grid-cols-1 gap-6 xl:grid-cols-2">
        {{-- Price trends placeholder --}}
        <section class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
            <h2 class="mb-4 text-sm font-semibold uppercase tracking-wide text-gray-500">
                {{ __('pahewo.dashboard.price_trends') }}
            </h2>
            <div class="flex h-48 items-center justify-center rounded-md border border-dashed border-gray-200 bg-gray-50 text-sm text-gray-500">
                📈 {{ __('pahewo.common.no_data') }}
            </div>
        </section>

        {{-- Exchange rates --}}
        <section class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
            <h2 class="mb-4 text-sm font-semibold uppercase tracking-wide text-gray-500">
                {{ __('pahewo.dashboard.exchange_rates') }}
            </h2>

            @if (($exchangeRates ?? collect())->isNotEmpty())
                <ul class="divide-y divide-gray-100">
                    @foreach ($exchangeRates as $rate)
                        <li class="flex items-center justify-between py-3 text-sm">
                            <span class="font-medium text-gray-900">
                                {{ $rate->baseCurrency?->code }}/{{ $rate->quoteCurrency?->code }}
                            </span>
                            <span class="tabular-nums text-gray-700">
                                {{ number_format((float) $rate->rate, 0, ',', ' ') }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            @else
                <x-empty-state
                    icon="💱"
                    :title="__('pahewo.common.no_data')"
                    class="py-8"
                />
            @endif
        </section>
    </div>

    <div class="mb-6 grid grid-cols-1 gap-6 xl:grid-cols-2">
        {{-- Claims summary --}}
        <section class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
            <h2 class="mb-4 text-sm font-semibold uppercase tracking-wide text-gray-500">
                {{ __('pahewo.dashboard.claims_summary') }}
            </h2>

            @php
                $byStatus = $claimSummary['by_status'] ?? [];
            @endphp

            <dl class="space-y-3 text-sm">
                <div class="flex items-center justify-between">
                    <dt class="text-gray-600">{{ __('pahewo.dashboard.new_claims') }}</dt>
                    <dd class="font-semibold tabular-nums text-gray-900">{{ $byStatus['submitted'] ?? 0 }}</dd>
                </div>
                <div class="flex items-center justify-between">
                    <dt class="text-gray-600">{{ __('pahewo.dashboard.under_review') }}</dt>
                    <dd class="font-semibold tabular-nums text-gray-900">{{ $byStatus['under_review'] ?? 0 }}</dd>
                </div>
                <div class="flex items-center justify-between">
                    <dt class="text-gray-600">{{ __('pahewo.dashboard.overdue') }}</dt>
                    <dd class="font-semibold tabular-nums text-amber-600">
                        {{ ($byStatus['pending'] ?? 0) }}
                        @if (($byStatus['pending'] ?? 0) > 0)
                            <span aria-hidden="true">⚠</span>
                        @endif
                    </dd>
                </div>
                <div class="flex items-center justify-between">
                    <dt class="text-gray-600">{{ __('pahewo.dashboard.resolved') }}</dt>
                    <dd class="font-semibold tabular-nums text-gray-900">{{ $byStatus['resolved'] ?? 0 }}</dd>
                </div>
            </dl>
        </section>

        {{-- Needs attention --}}
        <section class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
            <h2 class="mb-4 text-sm font-semibold uppercase tracking-wide text-gray-500">
                {{ __('pahewo.dashboard.needs_attention') }}
            </h2>

            @if (! empty($attentionItems))
                <ul class="space-y-2 text-sm">
                    @foreach ($attentionItems as $item)
                        <li class="flex gap-2 rounded-md bg-amber-50 px-3 py-2 text-amber-800">
                            <span aria-hidden="true">⚠</span>
                            <span>{{ $item['message'] ?? $item }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <x-empty-state
                    icon="✅"
                    :title="__('pahewo.common.no_data')"
                    class="py-8"
                />
            @endif
        </section>
    </div>

    {{-- Recent activity --}}
    <section class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
        <h2 class="mb-4 text-sm font-semibold uppercase tracking-wide text-gray-500">
            {{ __('pahewo.dashboard.recent_activity') }}
        </h2>

        @if (($recentActivity ?? collect())->isNotEmpty())
            <ul class="divide-y divide-gray-100">
                @foreach ($recentActivity as $activity)
                    <li class="flex items-start justify-between gap-4 py-3 text-sm">
                        <span class="text-gray-700">{{ $activity['description'] }}</span>
                        <time class="shrink-0 text-xs text-gray-400" datetime="{{ $activity['occurred_at']->toIso8601String() }}">
                            {{ $activity['occurred_at']->format('H:i') }}
                        </time>
                    </li>
                @endforeach
            </ul>
        @else
            <x-empty-state class="py-8" />
        @endif
    </section>
</x-pahewo-layout>
