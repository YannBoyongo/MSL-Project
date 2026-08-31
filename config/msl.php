<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Sidebar navigation
    |--------------------------------------------------------------------------
    |
    | Each section groups menu items. Items are shown when the authenticated
    | user has the listed permission (@can). Set permission to null for items
    | visible to every authenticated user.
    |
    */

    'menu' => [
        [
            'section' => 'dashboard',
            'items' => [
                [
                    'permission' => null,
                    'route' => 'dashboard',
                    'label' => 'nav.overview',
                    'icon' => '🏠',
                    'active' => 'dashboard',
                ],
                [
                    'permission' => 'reports.view',
                    'route' => 'msl.statistics',
                    'label' => 'nav.statistics',
                    'icon' => '📊',
                    'active' => 'msl.statistics',
                ],
            ],
        ],
        [
            'section' => 'trade_info',
            'items' => [
                [
                    'permission' => 'markets.view',
                    'route' => 'msl.markets.index',
                    'label' => 'nav.markets',
                    'icon' => '🏪',
                    'active' => 'msl.markets.*',
                ],
                [
                    'permission' => 'commodities.view',
                    'route' => 'msl.commodities.index',
                    'label' => 'nav.commodities',
                    'icon' => '📦',
                    'active' => 'msl.commodities.*',
                ],
                [
                    'permission' => 'prices.view',
                    'route' => 'msl.commodity-prices.index',
                    'label' => 'nav.daily_prices',
                    'icon' => '💰',
                    'active' => 'msl.commodity-prices.*',
                ],
                [
                    'permission' => 'prices.create',
                    'route' => 'msl.commodity-prices.create',
                    'label' => 'nav.record_price',
                    'icon' => '➕',
                    'active' => 'msl.commodity-prices.create',
                ],
                [
                    'permission' => 'exchange_rates.view',
                    'route' => 'msl.exchange-rates.index',
                    'label' => 'nav.exchange_rates',
                    'icon' => '💱',
                    'active' => 'msl.exchange-rates.*',
                ],
                [
                    'permission' => 'exchange_rates.create',
                    'route' => 'msl.exchange-rates.create',
                    'label' => 'nav.record_exchange_rate',
                    'icon' => '➕',
                    'active' => 'msl.exchange-rates.create',
                ],
                [
                    'permission' => 'exchange_rates.view',
                    'route' => 'msl.forex-bureaus.index',
                    'label' => 'nav.forex_bureaus',
                    'icon' => '🏦',
                    'active' => 'msl.forex-bureaus.*',
                ],
                [
                    'permission' => 'prices.view',
                    'route' => 'msl.prices.compare',
                    'label' => 'nav.compare_prices',
                    'icon' => '🔎',
                    'active' => 'msl.prices.compare',
                ],
                [
                    'permission' => 'exchange_rates.view',
                    'route' => 'msl.currency-converter',
                    'label' => 'nav.currency_converter',
                    'icon' => '🧮',
                    'active' => 'msl.currency-converter',
                ],
            ],
        ],
        [
            'section' => 'border_info',
            'items' => [
                [
                    'permission' => 'travel_documents.view',
                    'route' => 'msl.border-crossings.index',
                    'label' => 'nav.border_crossings',
                    'icon' => '🚧',
                    'active' => 'msl.border-crossings.*',
                ],
                [
                    'permission' => 'travel_documents.view',
                    'route' => 'msl.travel-documents.index',
                    'label' => 'nav.travel_documents',
                    'icon' => '📄',
                    'active' => 'msl.travel-documents.*',
                ],
                [
                    'permission' => 'travel_documents.view',
                    'route' => 'msl.travel-requirements',
                    'label' => 'nav.travel_requirements',
                    'icon' => '📋',
                    'active' => 'msl.travel-requirements',
                ],
            ],
        ],
        [
            'section' => 'claims',
            'items' => [
                [
                    'permission' => 'claims.create',
                    'route' => 'msl.claims.create',
                    'label' => 'nav.submit_claim',
                    'icon' => '➕',
                    'active' => 'msl.claims.create',
                ],
                [
                    'permission' => 'claims.view',
                    'route' => 'msl.claims.index',
                    'label' => 'nav.claims',
                    'icon' => '📝',
                    'active' => 'msl.claims.*',
                ],
                [
                    'permission' => 'claims.review',
                    'route' => 'msl.claim-types.index',
                    'label' => 'nav.claim_types',
                    'icon' => '🏷',
                    'active' => 'msl.claim-types.*',
                ],
            ],
        ],
        [
            'section' => 'configuration',
            'items' => [
                [
                    'permission' => 'countries.view',
                    'route' => 'msl.countries.index',
                    'label' => 'nav.countries',
                    'icon' => '🌍',
                    'active' => 'msl.countries.*',
                ],
                [
                    'permission' => 'countries.manage',
                    'route' => 'msl.languages.index',
                    'label' => 'nav.languages',
                    'icon' => '🗣',
                    'active' => 'msl.languages.*',
                ],
                [
                    'permission' => 'countries.manage',
                    'route' => 'msl.currencies.index',
                    'label' => 'nav.currencies',
                    'icon' => '💵',
                    'active' => 'msl.currencies.*',
                ],
                [
                    'permission' => 'commodities.view',
                    'route' => 'msl.measurement-units.index',
                    'label' => 'nav.measurement_units',
                    'icon' => '⚖',
                    'active' => 'msl.measurement-units.*',
                ],
                [
                    'permission' => 'commodities.view',
                    'route' => 'msl.commodity-categories.index',
                    'label' => 'nav.commodity_categories',
                    'icon' => '📂',
                    'active' => 'msl.commodity-categories.*',
                ],
            ],
        ],
        [
            'section' => 'users_access',
            'items' => [
                [
                    'permission' => 'users.view',
                    'route' => 'msl.users.index',
                    'label' => 'nav.users',
                    'icon' => '👥',
                    'active' => 'msl.users.*',
                ],
                [
                    'permission' => 'roles.manage',
                    'route' => 'msl.roles.index',
                    'label' => 'nav.roles',
                    'icon' => '🛡',
                    'active' => 'msl.roles.*',
                ],
            ],
        ],
        [
            'section' => 'reports',
            'items' => [
                [
                    'permission' => 'reports.view',
                    'route' => 'msl.reports.index',
                    'label' => 'nav.reports',
                    'icon' => '📊',
                    'active' => 'msl.reports.*',
                ],
                [
                    'permission' => 'reports.view',
                    'route' => 'msl.reports.price-trends',
                    'label' => 'nav.price_trends',
                    'icon' => '📈',
                    'active' => 'msl.reports.price-trends',
                ],
                [
                    'permission' => 'reports.view',
                    'route' => 'msl.reports.exchange-rate-trends',
                    'label' => 'nav.exchange_rate_trends',
                    'icon' => '📈',
                    'active' => 'msl.reports.exchange-rate-trends',
                ],
                [
                    'permission' => 'reports.view',
                    'route' => 'msl.reports.claims',
                    'label' => 'nav.claim_reports',
                    'icon' => '📋',
                    'active' => 'msl.reports.claims',
                ],
            ],
        ],
        [
            'section' => 'activity',
            'items' => [
                [
                    'permission' => 'prices.view',
                    'route' => 'msl.submissions.index',
                    'label' => 'nav.my_submissions',
                    'icon' => '📋',
                    'active' => 'msl.submissions.*',
                ],
                [
                    'permission' => 'prices.view',
                    'route' => 'msl.submissions.history',
                    'label' => 'nav.submission_history',
                    'icon' => '🕒',
                    'active' => 'msl.submissions.history',
                ],
            ],
        ],
        [
            'section' => 'support',
            'items' => [
                [
                    'permission' => 'users.view',
                    'route' => 'msl.contact-persons.index',
                    'label' => 'nav.contact_persons',
                    'icon' => '👤',
                    'active' => 'msl.contact-persons.*',
                ],
                [
                    'permission' => null,
                    'route' => 'msl.help',
                    'label' => 'nav.help',
                    'icon' => '❓',
                    'active' => 'msl.help',
                ],
            ],
        ],
        [
            'section' => 'system',
            'items' => [
                [
                    'permission' => 'roles.manage',
                    'route' => 'msl.settings',
                    'label' => 'nav.settings',
                    'icon' => '⚙',
                    'active' => 'msl.settings',
                ],
            ],
        ],
        [
            'section' => 'account',
            'items' => [
                [
                    'permission' => null,
                    'route' => 'profile.edit',
                    'label' => 'nav.my_profile',
                    'icon' => '👤',
                    'active' => 'profile.*',
                ],
                [
                    'permission' => null,
                    'route' => 'msl.language',
                    'label' => 'nav.language',
                    'icon' => '🌐',
                    'active' => 'msl.language',
                ],
            ],
        ],
    ],

];
