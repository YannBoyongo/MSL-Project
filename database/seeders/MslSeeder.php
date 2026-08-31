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

class MslSeeder extends Seeder
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
            'CDF' => ['name' => 'Congolese Franc', 'symbol' => 'FC'],
            'RWF' => ['name' => 'Rwandan Franc', 'symbol' => 'FRw'],
            'BIF' => ['name' => 'Burundian Franc', 'symbol' => 'FBu'],
            'USD' => ['name' => 'US Dollar', 'symbol' => '$'],
        ];

        $currencies = [];

        foreach ($definitions as $code => $attributes) {
            $currencies[$code] = Currency::query()->firstOrCreate(
                ['code' => $code],
                [
                    'name' => $attributes['name'],
                    'symbol' => $attributes['symbol'],
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
            'CD' => ['CDF', 'USD'],
            'RW' => ['RWF', 'USD'],
            'BI' => ['BIF', 'USD'],
        ];

        foreach ($links as $isoCode => $currencyCodes) {
            $country = $countries[$isoCode] ?? null;

            if ($country === null) {
                continue;
            }

            foreach ($currencyCodes as $currencyCode) {
                $currency = $currencies[$currencyCode] ?? null;

                if ($currency === null) {
                    continue;
                }

                DB::table('country_currency')->updateOrInsert(
                    [
                        'country_id' => $country->id,
                        'currency_id' => $currency->id,
                    ],
                    [
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
        $definitions = [
            [
                'code' => 'food_grains',
                'translations' => [
                    'en' => 'Food Grains',
                    'fr' => 'Céréales et grains',
                    'sw' => 'Nafaka',
                ],
            ],
            [
                'code' => 'tubers',
                'translations' => [
                    'en' => 'Roots and Tubers',
                    'fr' => 'Racines et tubercules',
                    'sw' => 'Mizizi na viazi',
                ],
            ],
            [
                'code' => 'vegetables',
                'translations' => [
                    'en' => 'Vegetables',
                    'fr' => 'Légumes',
                    'sw' => 'Mbogamboga',
                ],
            ],
            [
                'code' => 'livestock',
                'translations' => [
                    'en' => 'Livestock and Fish',
                    'fr' => 'Bétail et poisson',
                    'sw' => 'Mifugo na samaki',
                ],
            ],
        ];

        foreach ($definitions as $definition) {
            $category = CommodityCategory::query()->firstOrCreate(
                ['code' => $definition['code']],
                ['is_active' => true],
            );

            foreach ($definition['translations'] as $languageCode => $name) {
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
        $definitions = [
            [
                'code' => 'kg',
                'symbol' => 'kg',
                'translations' => [
                    'en' => 'Kilogram',
                    'fr' => 'Kilogramme',
                    'sw' => 'Kilo',
                ],
            ],
            [
                'code' => 'sack_50kg',
                'symbol' => 'sac 50kg',
                'translations' => [
                    'en' => 'Sack of 50kg',
                    'fr' => 'Sac de 50kg',
                    'sw' => 'Gunia la 50kg',
                ],
            ],
            [
                'code' => 'piece',
                'symbol' => 'pc',
                'translations' => [
                    'en' => 'Piece',
                    'fr' => 'Pièce',
                    'sw' => 'Kipande',
                ],
            ],
            [
                'code' => 'basin',
                'symbol' => 'bassin',
                'translations' => [
                    'en' => 'Basin',
                    'fr' => 'Bassin',
                    'sw' => 'Beseni',
                ],
            ],
        ];

        foreach ($definitions as $definition) {
            $unit = MeasurementUnit::query()->firstOrCreate(
                ['code' => $definition['code']],
                [
                    'symbol' => $definition['symbol'],
                    'is_active' => true,
                ],
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
        $definitions = [
            [
                'code' => 'passport',
                'translations' => [
                    'en' => 'Passport',
                    'fr' => 'Passeport',
                    'sw' => 'Pasi ya kusafiria',
                ],
            ],
            [
                'code' => 'national_id',
                'translations' => [
                    'en' => 'National ID',
                    'fr' => 'Carte d\'identité nationale',
                    'sw' => 'Kitambulisho cha taifa',
                ],
            ],
            [
                'code' => 'border_pass',
                'translations' => [
                    'en' => 'Cross-Border Pass (CPGL)',
                    'fr' => 'Jeton transfrontalier (CPGL)',
                    'sw' => 'Kadi ya kuvuka mpaka (CPGL)',
                ],
            ],
            [
                'code' => 'str_form',
                'translations' => [
                    'en' => 'COMESA STR Form',
                    'fr' => 'Formulaire COMESA REC',
                    'sw' => 'Fomu ya COMESA STR',
                ],
            ],
        ];

        foreach ($definitions as $definition) {
            $docType = DocumentType::query()->firstOrCreate(
                ['code' => $definition['code']],
                ['is_active' => true],
            );

            foreach ($definition['translations'] as $languageCode => $name) {
                DocumentTypeTranslation::query()->updateOrCreate(
                    [
                        'document_type_id' => $docType->id,
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
        $definitions = [
            [
                'code' => 'harassment',
                'translations' => [
                    'en' => 'Harassment',
                    'fr' => 'Harcèlement ou intimidation',
                    'sw' => 'Unyanyasaji au vitisho',
                ],
            ],
            [
                'code' => 'illegal_tax',
                'translations' => [
                    'en' => 'Illegal Taxation / Extortion',
                    'fr' => 'Taxation illégale ou tracasserie financière',
                    'sw' => 'Ushuru usio halali au unyang\'anyi',
                ],
            ],
            [
                'code' => 'delay',
                'translations' => [
                    'en' => 'Unreasonable Clearance Delay',
                    'fr' => 'Retard anormal lors du dédouanement',
                    'sw' => 'Kucheleweshwa kusiko kwa kawaida mpakani',
                ],
            ],
            [
                'code' => 'confiscation',
                'translations' => [
                    'en' => 'Goods Confiscation',
                    'fr' => 'Saisie arbitraire de marchandises',
                    'sw' => 'Kukamatwa kwa bidhaa bila haki',
                ],
            ],
        ];

        foreach ($definitions as $definition) {
            $claimType = ClaimType::query()->firstOrCreate(
                ['code' => $definition['code']],
                ['is_active' => true],
            );

            foreach ($definition['translations'] as $languageCode => $name) {
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
        $definitions = [
            'CD' => [
                ['name' => 'Marché Central de Bukavu', 'city' => 'Bukavu', 'latitude' => -2.5085, 'longitude' => 28.8608],
                ['name' => 'Marché de Birere (Goma)', 'city' => 'Goma', 'latitude' => -1.6741, 'longitude' => 29.2385],
                ['name' => 'Marché d\'Uvira', 'city' => 'Uvira', 'latitude' => -3.3965, 'longitude' => 29.1378],
            ],
            'RW' => [
                ['name' => 'Marché Transfrontalier de Rubavu', 'city' => 'Rubavu', 'latitude' => -1.6974, 'longitude' => 29.2612],
                ['name' => 'Marché de Kamembe (Rusizi)', 'city' => 'Rusizi', 'latitude' => -2.4842, 'longitude' => 28.9077],
            ],
            'BI' => [
                ['name' => 'Marché Central de Bujumbura (Siyoni)', 'city' => 'Bujumbura', 'latitude' => -3.3822, 'longitude' => 29.3644],
                ['name' => 'Marché de Rugombo (Cibitoke)', 'city' => 'Cibitoke', 'latitude' => -2.8333, 'longitude' => 29.1167],
            ],
        ];

        foreach ($definitions as $isoCode => $marketList) {
            $country = $countries[$isoCode] ?? null;

            if ($country === null) {
                continue;
            }

            foreach ($marketList as $marketData) {
                Market::query()->firstOrCreate(
                    [
                        'country_id' => $country->id,
                        'name' => $marketData['name'],
                    ],
                    [
                        'city' => $marketData['city'],
                        'latitude' => $marketData['latitude'],
                        'longitude' => $marketData['longitude'],
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
        $grains = CommodityCategory::query()->where('code', 'food_grains')->first();
        $tubers = CommodityCategory::query()->where('code', 'tubers')->first();
        $vegetables = CommodityCategory::query()->where('code', 'vegetables')->first();
        $kg = MeasurementUnit::query()->where('code', 'kg')->first();

        if ($grains === null || $tubers === null || $vegetables === null || $kg === null) {
            return;
        }

        $definitions = [
            [
                'code' => 'maize_flour',
                'name' => 'Maize Flour',
                'category_id' => $grains->id,
                'translations' => [
                    'en' => 'Maize Flour',
                    'fr' => 'Farine de maïs',
                    'sw' => 'Unga wa mahindi',
                ],
            ],
            [
                'code' => 'beans',
                'name' => 'Dry Beans',
                'category_id' => $grains->id,
                'translations' => [
                    'en' => 'Dry Beans',
                    'fr' => 'Haricots secs',
                    'sw' => 'Maharage makavu',
                ],
            ],
            [
                'code' => 'cassava_flour',
                'name' => 'Cassava Flour',
                'category_id' => $tubers->id,
                'translations' => [
                    'en' => 'Cassava Flour',
                    'fr' => 'Farine de manioc',
                    'sw' => 'Unga wa muhogo',
                ],
            ],
            [
                'code' => 'tomatoes',
                'name' => 'Fresh Tomatoes',
                'category_id' => $vegetables->id,
                'translations' => [
                    'en' => 'Fresh Tomatoes',
                    'fr' => 'Tomates fraîches',
                    'sw' => 'Nyanya mbichi',
                ],
            ],
        ];

        foreach ($definitions as $definition) {
            $commodity = Commodity::query()->firstOrCreate(
                ['code' => $definition['code']],
                [
                    'commodity_category_id' => $definition['category_id'],
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
            ['email' => 'admin@msl.org'],
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
