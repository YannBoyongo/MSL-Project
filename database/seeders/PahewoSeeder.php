<?php

namespace Database\Seeders;

use App\Models\ClaimType;
use App\Models\ClaimTypeTranslation;
use App\Models\Commodity;
use App\Models\CommodityCategory;
use App\Models\CommodityCategoryTranslation;
use App\Models\CommodityTranslation;
use App\Models\Country;
use App\Models\Currency;
use App\Models\DocumentType;
use App\Models\DocumentTypeTranslation;
use App\Models\Language;
use App\Models\Market;
use App\Models\MeasurementUnit;
use App\Models\MeasurementUnitTranslation;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class PahewoSeeder extends Seeder
{
    public function run(): void
    {
        Model::unguarded(function (): void {
            $this->seedApplicationData();
        });
    }

    private function seedApplicationData(): void
    {
        $languages = $this->seedLanguages();
        $countries = $this->seedCountries();
        $currencies = $this->seedCurrencies();
        $this->linkCurrenciesToCountries($countries, $currencies);
        $this->seedCommodityCategories($languages);
        $this->seedMeasurementUnits($languages);
        $this->seedDocumentTypes($languages);
        $this->seedClaimTypes($languages);
        $this->seedMarkets($countries);
        $this->seedCommodities($languages);
        $this->seedSuperAdmin($countries, $languages);
    }

    /**
     * @return array<string, Language>
     */
    private function seedLanguages(): array
    {
        $definitions = [
            'en' => 'English',
            'fr' => 'Français',
            'sw' => 'Kiswahili',
        ];

        $languages = [];

        foreach ($definitions as $code => $name) {
            $languages[$code] = Language::query()->firstOrCreate(
                ['code' => $code],
                ['name' => $name, 'is_active' => true],
            );
        }

        return $languages;
    }

    /**
     * @return array<string, Country>
     */
    private function seedCountries(): array
    {
        $definitions = [
            'CD' => ['name' => 'Democratic Republic of the Congo', 'phone_code' => '+243'],
            'RW' => ['name' => 'Rwanda', 'phone_code' => '+250'],
            'BI' => ['name' => 'Burundi', 'phone_code' => '+257'],
        ];

        $countries = [];

        foreach ($definitions as $isoCode => $attributes) {
            $countries[$isoCode] = Country::query()->firstOrCreate(
                ['iso_code' => $isoCode],
                [
                    'name' => $attributes['name'],
                    'phone_code' => $attributes['phone_code'],
                    'is_active' => true,
                ],
            );
        }

        return $countries;
    }

    /**
     * @return array<string, Currency>
     */
    private function seedCurrencies(): array
    {
        $definitions = [
            'USD' => ['name' => 'US Dollar', 'symbol' => '$', 'decimal_places' => 2],
            'CDF' => ['name' => 'Congolese Franc', 'symbol' => 'FC', 'decimal_places' => 2],
            'RWF' => ['name' => 'Rwandan Franc', 'symbol' => 'FRw', 'decimal_places' => 0],
            'BIF' => ['name' => 'Burundian Franc', 'symbol' => 'FBu', 'decimal_places' => 0],
        ];

        $currencies = [];

        foreach ($definitions as $code => $attributes) {
            $currencies[$code] = Currency::query()->firstOrCreate(
                ['code' => $code],
                [
                    'name' => $attributes['name'],
                    'symbol' => $attributes['symbol'],
                    'decimal_places' => $attributes['decimal_places'],
                    'is_active' => true,
                ],
            );
        }

        return $currencies;
    }

    /**
     * @param  array<string, Country>  $countries
     * @param  array<string, Currency>  $currencies
     */
    private function linkCurrenciesToCountries(array $countries, array $currencies): void
    {
        $links = [
            'CD' => [
                ['currency' => 'CDF', 'is_default' => true],
                ['currency' => 'USD', 'is_default' => false],
            ],
            'RW' => [
                ['currency' => 'RWF', 'is_default' => true],
                ['currency' => 'USD', 'is_default' => false],
            ],
            'BI' => [
                ['currency' => 'BIF', 'is_default' => true],
                ['currency' => 'USD', 'is_default' => false],
            ],
        ];

        foreach ($links as $isoCode => $countryCurrencies) {
            foreach ($countryCurrencies as $link) {
                DB::table('country_currency')->updateOrInsert(
                    [
                        'country_id' => $countries[$isoCode]->id,
                        'currency_id' => $currencies[$link['currency']]->id,
                    ],
                    [
                        'is_default' => $link['is_default'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                );
            }
        }
    }

    /**
     * @param  array<string, Language>  $languages
     */
    private function seedCommodityCategories(array $languages): void
    {
        $categories = [
            'CEREALS' => ['en' => 'Cereals', 'fr' => 'Céréales', 'sw' => 'Nafaka'],
            'VEGETABLES' => ['en' => 'Vegetables', 'fr' => 'Légumes', 'sw' => 'Mboga'],
            'FRUITS' => ['en' => 'Fruits', 'fr' => 'Fruits', 'sw' => 'Matunda'],
            'LIVESTOCK' => ['en' => 'Livestock', 'fr' => 'Bétail', 'sw' => 'Mifugo'],
            'FISH' => ['en' => 'Fish', 'fr' => 'Poisson', 'sw' => 'Samaki'],
            'OTHER' => ['en' => 'Other', 'fr' => 'Autre', 'sw' => 'Nyingine'],
        ];

        foreach ($categories as $code => $translations) {
            $category = CommodityCategory::query()->firstOrCreate(
                ['code' => $code],
                ['is_active' => true],
            );

            foreach ($translations as $languageCode => $name) {
                CommodityCategoryTranslation::query()->updateOrCreate(
                    [
                        'commodity_category_id' => $category->id,
                        'language_id' => $languages[$languageCode]->id,
                    ],
                    ['name' => $name],
                );
            }
        }
    }

    /**
     * @param  array<string, Language>  $languages
     */
    private function seedMeasurementUnits(array $languages): void
    {
        $units = [
            'kg' => [
                'symbol' => 'kg',
                'translations' => ['en' => 'Kilogram', 'fr' => 'Kilogramme', 'sw' => 'Kilo'],
            ],
            'litre' => [
                'symbol' => 'L',
                'translations' => ['en' => 'Litre', 'fr' => 'Litre', 'sw' => 'Lita'],
            ],
            'bag' => [
                'symbol' => 'bag',
                'translations' => ['en' => 'Bag', 'fr' => 'Sac', 'sw' => 'Gunia'],
            ],
            'tonne' => [
                'symbol' => 't',
                'translations' => ['en' => 'Tonne', 'fr' => 'Tonne', 'sw' => 'Tani'],
            ],
            'piece' => [
                'symbol' => 'pc',
                'translations' => ['en' => 'Piece', 'fr' => 'Pièce', 'sw' => 'Kipande'],
            ],
        ];

        foreach ($units as $code => $definition) {
            $unit = MeasurementUnit::query()->firstOrCreate(
                ['code' => $code],
                ['symbol' => $definition['symbol'], 'is_active' => true],
            );

            foreach ($definition['translations'] as $languageCode => $name) {
                MeasurementUnitTranslation::query()->updateOrCreate(
                    [
                        'measurement_unit_id' => $unit->id,
                        'language_id' => $languages[$languageCode]->id,
                    ],
                    ['name' => $name],
                );
            }
        }
    }

    /**
     * @param  array<string, Language>  $languages
     */
    private function seedDocumentTypes(array $languages): void
    {
        $types = [
            'PASSPORT' => ['en' => 'Passport', 'fr' => 'Passeport', 'sw' => 'Pasipoti'],
            'NATIONAL_ID' => ['en' => 'National ID', 'fr' => 'Carte d\'identité nationale', 'sw' => 'Kitambulisho cha taifa'],
            'LAISSEZ_PASSER' => ['en' => 'Laissez-passer', 'fr' => 'Laissez-passer', 'sw' => 'Laissez-passer'],
            'VISA' => ['en' => 'Visa', 'fr' => 'Visa', 'sw' => 'Visa'],
            'YELLOW_FEVER_CERTIFICATE' => ['en' => 'Yellow Fever Certificate', 'fr' => 'Certificat de fièvre jaune', 'sw' => 'Cheti cha homa ya manjano'],
            'CUSTOMS_DECLARATION' => ['en' => 'Customs Declaration', 'fr' => 'Déclaration douanière', 'sw' => 'Tamko la forodha'],
            'TRADER_PERMIT' => ['en' => 'Trader Permit', 'fr' => 'Permis de commerçant', 'sw' => 'Kibali cha mfanyabiashara'],
        ];

        foreach ($types as $code => $translations) {
            $documentType = DocumentType::query()->firstOrCreate(
                ['code' => $code],
                ['is_active' => true],
            );

            foreach ($translations as $languageCode => $name) {
                DocumentTypeTranslation::query()->updateOrCreate(
                    [
                        'document_type_id' => $documentType->id,
                        'language_id' => $languages[$languageCode]->id,
                    ],
                    ['name' => $name],
                );
            }
        }
    }

    /**
     * @param  array<string, Language>  $languages
     */
    private function seedClaimTypes(array $languages): void
    {
        $types = [
            'ILLEGAL_FEE' => ['en' => 'Illegal Fee', 'fr' => 'Frais illégaux', 'sw' => 'Ada haramu'],
            'HARASSMENT' => ['en' => 'Harassment', 'fr' => 'Harcèlement', 'sw' => 'Unyanyasaji'],
            'BORDER_DELAY' => ['en' => 'Border Delay', 'fr' => 'Retard à la frontière', 'sw' => 'Ucheleweshaji mpakani'],
            'DOCUMENT_PROBLEM' => ['en' => 'Document Problem', 'fr' => 'Problème de document', 'sw' => 'Tatizo la hati'],
            'CONFISCATION' => ['en' => 'Confiscation', 'fr' => 'Confiscation', 'sw' => 'Ukomeshaji'],
            'MARKET_DISPUTE' => ['en' => 'Market Dispute', 'fr' => 'Litige de marché', 'sw' => 'Mgogoro wa soko'],
            'OTHER' => ['en' => 'Other', 'fr' => 'Autre', 'sw' => 'Nyingine'],
        ];

        foreach ($types as $code => $translations) {
            $claimType = ClaimType::query()->firstOrCreate(
                ['code' => $code],
                ['is_active' => true],
            );

            foreach ($translations as $languageCode => $name) {
                ClaimTypeTranslation::query()->updateOrCreate(
                    [
                        'claim_type_id' => $claimType->id,
                        'language_id' => $languages[$languageCode]->id,
                    ],
                    ['name' => $name],
                );
            }
        }
    }

    /**
     * @param  array<string, Country>  $countries
     */
    private function seedMarkets(array $countries): void
    {
        $markets = [
            'CD' => [
                ['name' => 'Marché Central de Kinshasa', 'city' => 'Kinshasa'],
                ['name' => 'Marché de Lubumbashi', 'city' => 'Lubumbashi'],
            ],
            'RW' => [
                ['name' => 'Kimisagara Market', 'city' => 'Kigali'],
                ['name' => 'Nyabugogo Market', 'city' => 'Kigali'],
            ],
            'BI' => [
                ['name' => 'Marché Central de Bujumbura', 'city' => 'Bujumbura'],
                ['name' => 'Marché de Gitega', 'city' => 'Gitega'],
            ],
        ];

        foreach ($markets as $isoCode => $countryMarkets) {
            foreach ($countryMarkets as $marketData) {
                Market::query()->firstOrCreate(
                    [
                        'country_id' => $countries[$isoCode]->id,
                        'name' => $marketData['name'],
                    ],
                    [
                        'city' => $marketData['city'],
                        'is_active' => true,
                    ],
                );
            }
        }
    }

    /**
     * @param  array<string, Language>  $languages
     */
    private function seedCommodities(array $languages): void
    {
        $kg = MeasurementUnit::query()->where('code', 'kg')->firstOrFail();
        $cereals = CommodityCategory::query()->where('code', 'CEREALS')->firstOrFail();
        $vegetables = CommodityCategory::query()->where('code', 'VEGETABLES')->firstOrFail();

        $commodities = [
            'MAIZE' => [
                'category' => $cereals,
                'translations' => ['en' => 'Maize', 'fr' => 'Maïs', 'sw' => 'Mahindi'],
            ],
            'RICE' => [
                'category' => $cereals,
                'translations' => ['en' => 'Rice', 'fr' => 'Riz', 'sw' => 'Mchele'],
            ],
            'BEANS' => [
                'category' => $cereals,
                'translations' => ['en' => 'Beans', 'fr' => 'Haricots', 'sw' => 'Maharagwe'],
            ],
            'POTATOES' => [
                'category' => $vegetables,
                'translations' => ['en' => 'Potatoes', 'fr' => 'Pommes de terre', 'sw' => 'Viazi'],
            ],
        ];

        foreach ($commodities as $code => $definition) {
            $commodity = Commodity::query()->firstOrCreate(
                ['code' => $code],
                [
                    'commodity_category_id' => $definition['category']->id,
                    'measurement_unit_id' => $kg->id,
                    'is_active' => true,
                ],
            );

            foreach ($definition['translations'] as $languageCode => $name) {
                CommodityTranslation::query()->updateOrCreate(
                    [
                        'commodity_id' => $commodity->id,
                        'language_id' => $languages[$languageCode]->id,
                    ],
                    ['name' => $name],
                );
            }
        }
    }

    /**
     * @param  array<string, Country>  $countries
     * @param  array<string, Language>  $languages
     */
    private function seedSuperAdmin(array $countries, array $languages): void
    {
        $user = User::query()->updateOrCreate(
            ['email' => 'admin@pahewo.org'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'preferred_language_id' => $languages['fr']->id,
            ],
        );

        $role = Role::findByName('super-admin', 'web');

        DB::table('model_has_roles')->updateOrInsert(
            [
                'role_id' => $role->id,
                'model_type' => User::class,
                'model_id' => $user->id,
            ],
            [],
        );

        foreach ($countries as $country) {
            DB::table('country_user')->updateOrInsert(
                [
                    'country_id' => $country->id,
                    'user_id' => $user->id,
                ],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            );
        }
    }
}
