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
                    'route' => 'pahewo.statistics',
                    'label' => 'nav.statistics',
                    'icon' => '📊',
                    'active' => 'pahewo.statistics',
                ],
            ],
        ],
        [
            'section' => 'trade_info',
            'items' => [
                [
                    'permission' => 'markets.view',
                    'route' => 'pahewo.markets.index',
                    'label' => 'nav.markets',
                    'icon' => '🏪',
                    'active' => 'pahewo.markets.*',
                ],
                [
                    'permission' => 'commodities.view',
                    'route' => 'pahewo.commodities.index',
                    'label' => 'nav.commodities',
                    'icon' => '📦',
                    'active' => 'pahewo.commodities.*',
                ],
                [
                    'permission' => 'prices.view',
                    'route' => 'pahewo.commodity-prices.index',
                    'label' => 'nav.daily_prices',
                    'icon' => '💰',
                    'active' => 'pahewo.commodity-prices.*',
                ],
                [
                    'permission' => 'prices.create',
                    'route' => 'pahewo.commodity-prices.create',
                    'label' => 'nav.record_price',
                    'icon' => '➕',
                    'active' => 'pahewo.commodity-prices.create',
                ],
                [
                    'permission' => 'exchange_rates.view',
                    'route' => 'pahewo.exchange-rates.index',
                    'label' => 'nav.exchange_rates',
                    'icon' => '💱',
                    'active' => 'pahewo.exchange-rates.*',
                ],
                [
                    'permission' => 'exchange_rates.create',
                    'route' => 'pahewo.exchange-rates.create',
                    'label' => 'nav.record_exchange_rate',
                    'icon' => '➕',
                    'active' => 'pahewo.exchange-rates.create',
                ],
                [
                    'permission' => 'exchange_rates.view',
                    'route' => 'pahewo.forex-bureaus.index',
                    'label' => 'nav.forex_bureaus',
                    'icon' => '🏦',
                    'active' => 'pahewo.forex-bureaus.*',
                ],
                [
                    'permission' => 'prices.view',
                    'route' => 'pahewo.prices.compare',
                    'label' => 'nav.compare_prices',
                    'icon' => '🔎',
                    'active' => 'pahewo.prices.compare',
                ],
                [
                    'permission' => 'exchange_rates.view',
                    'route' => 'pahewo.currency-converter',
                    'label' => 'nav.currency_converter',
                    'icon' => '🧮',
                    'active' => 'pahewo.currency-converter',
                ],
            ],
        ],
        [
            'section' => 'border_info',
            'items' => [
                [
                    'permission' => 'travel_documents.view',
                    'route' => 'pahewo.border-crossings.index',
                    'label' => 'nav.border_crossings',
                    'icon' => '🚧',
                    'active' => 'pahewo.border-crossings.*',
                ],
                [
                    'permission' => 'travel_documents.view',
                    'route' => 'pahewo.travel-documents.index',
                    'label' => 'nav.travel_documents',
                    'icon' => '📄',
                    'active' => 'pahewo.travel-documents.*',
                ],
                [
                    'permission' => 'travel_documents.view',
                    'route' => 'pahewo.travel-requirements',
                    'label' => 'nav.travel_requirements',
                    'icon' => '📋',
                    'active' => 'pahewo.travel-requirements',
                ],
            ],
        ],
        [
            'section' => 'claims',
            'items' => [
                [
                    'permission' => 'claims.create',
                    'route' => 'pahewo.claims.create',
                    'label' => 'nav.submit_claim',
                    'icon' => '➕',
                    'active' => 'pahewo.claims.create',
                ],
                [
                    'permission' => 'claims.view',
                    'route' => 'pahewo.claims.index',
                    'label' => 'nav.claims',
                    'icon' => '📝',
                    'active' => 'pahewo.claims.*',
                ],
                [
                    'permission' => 'claims.review',
                    'route' => 'pahewo.claim-types.index',
                    'label' => 'nav.claim_types',
                    'icon' => '🏷',
                    'active' => 'pahewo.claim-types.*',
                ],
            ],
        ],
        [
            'section' => 'configuration',
            'items' => [
                [
                    'permission' => 'countries.view',
                    'route' => 'pahewo.countries.index',
                    'label' => 'nav.countries',
                    'icon' => '🌍',
                    'active' => 'pahewo.countries.*',
                ],
                [
                    'permission' => 'countries.manage',
                    'route' => 'pahewo.languages.index',
                    'label' => 'nav.languages',
                    'icon' => '🗣',
                    'active' => 'pahewo.languages.*',
                ],
                [
                    'permission' => 'countries.manage',
                    'route' => 'pahewo.currencies.index',
                    'label' => 'nav.currencies',
                    'icon' => '💵',
                    'active' => 'pahewo.currencies.*',
                ],
                [
                    'permission' => 'commodities.view',
                    'route' => 'pahewo.measurement-units.index',
                    'label' => 'nav.measurement_units',
                    'icon' => '⚖',
                    'active' => 'pahewo.measurement-units.*',
                ],
                [
                    'permission' => 'commodities.view',
                    'route' => 'pahewo.commodity-categories.index',
                    'label' => 'nav.commodity_categories',
                    'icon' => '📂',
                    'active' => 'pahewo.commodity-categories.*',
                ],
            ],
        ],
        [
            'section' => 'users_access',
            'items' => [
                [
                    'permission' => 'users.view',
                    'route' => 'pahewo.users.index',
                    'label' => 'nav.users',
                    'icon' => '👥',
                    'active' => 'pahewo.users.*',
                ],
                [
                    'permission' => 'roles.manage',
                    'route' => 'pahewo.roles.index',
                    'label' => 'nav.roles',
                    'icon' => '🛡',
                    'active' => 'pahewo.roles.*',
                ],
            ],
        ],
        [
            'section' => 'reports',
            'items' => [
                [
                    'permission' => 'reports.view',
                    'route' => 'pahewo.reports.index',
                    'label' => 'nav.reports',
                    'icon' => '📊',
                    'active' => 'pahewo.reports.*',
                ],
                [
                    'permission' => 'reports.view',
                    'route' => 'pahewo.reports.price-trends',
                    'label' => 'nav.price_trends',
                    'icon' => '📈',
                    'active' => 'pahewo.reports.price-trends',
                ],
                [
                    'permission' => 'reports.view',
                    'route' => 'pahewo.reports.exchange-rate-trends',
                    'label' => 'nav.exchange_rate_trends',
                    'icon' => '📈',
                    'active' => 'pahewo.reports.exchange-rate-trends',
                ],
                [
                    'permission' => 'reports.view',
                    'route' => 'pahewo.reports.claims',
                    'label' => 'nav.claim_reports',
                    'icon' => '📋',
                    'active' => 'pahewo.reports.claims',
                ],
            ],
        ],
        [
            'section' => 'activity',
            'items' => [
                [
                    'permission' => 'prices.view',
                    'route' => 'pahewo.submissions.index',
                    'label' => 'nav.my_submissions',
                    'icon' => '📋',
                    'active' => 'pahewo.submissions.*',
                ],
                [
                    'permission' => 'prices.view',
                    'route' => 'pahewo.submissions.history',
                    'label' => 'nav.submission_history',
                    'icon' => '🕒',
                    'active' => 'pahewo.submissions.history',
                ],
            ],
        ],
        [
            'section' => 'support',
            'items' => [
                [
                    'permission' => 'users.view',
                    'route' => 'pahewo.contact-persons.index',
                    'label' => 'nav.contact_persons',
                    'icon' => '👤',
                    'active' => 'pahewo.contact-persons.*',
                ],
                [
                    'permission' => null,
                    'route' => 'pahewo.help',
                    'label' => 'nav.help',
                    'icon' => '❓',
                    'active' => 'pahewo.help',
                ],
            ],
        ],
        [
            'section' => 'system',
            'items' => [
                [
                    'permission' => 'roles.manage',
                    'route' => 'pahewo.settings',
                    'label' => 'nav.settings',
                    'icon' => '⚙',
                    'active' => 'pahewo.settings',
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
                    'route' => 'pahewo.language',
                    'label' => 'nav.language',
                    'icon' => '🌐',
                    'active' => 'pahewo.language',
                ],
            ],
        ],
    ],

];
