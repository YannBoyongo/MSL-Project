<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class PahewoMenuRoutesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var list<string>
     */
    private array $menuRoutes = [
        'dashboard',
        'pahewo.statistics',
        'pahewo.markets.index',
        'pahewo.commodities.index',
        'pahewo.commodity-prices.index',
        'pahewo.commodity-prices.create',
        'pahewo.exchange-rates.index',
        'pahewo.exchange-rates.create',
        'pahewo.forex-bureaus.index',
        'pahewo.prices.compare',
        'pahewo.currency-converter',
        'pahewo.border-crossings.index',
        'pahewo.travel-documents.index',
        'pahewo.travel-requirements',
        'pahewo.claims.create',
        'pahewo.claims.index',
        'pahewo.claim-types.index',
        'pahewo.countries.index',
        'pahewo.languages.index',
        'pahewo.currencies.index',
        'pahewo.measurement-units.index',
        'pahewo.commodity-categories.index',
        'pahewo.users.index',
        'pahewo.roles.index',
        'pahewo.reports.index',
        'pahewo.reports.price-trends',
        'pahewo.reports.exchange-rate-trends',
        'pahewo.reports.claims',
        'pahewo.submissions.index',
        'pahewo.submissions.history',
        'pahewo.contact-persons.index',
        'pahewo.help',
        'pahewo.settings',
        'profile.edit',
        'pahewo.language',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleAndPermissionSeeder::class);
    }

    public function test_all_menu_routes_are_registered(): void
    {
        foreach ($this->menuRoutes as $routeName) {
            $this->assertTrue(
                Route::has($routeName),
                "Route [{$routeName}] is not registered."
            );
        }
    }

    public function test_super_admin_can_access_all_pahewo_menu_pages(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->assignRole('super-admin');

        foreach ($this->menuRoutes as $routeName) {
            if ($routeName === 'profile.edit') {
                continue;
            }

            $response = $this->actingAs($user)->get(route($routeName));

            $this->assertNotEquals(
                404,
                $response->getStatusCode(),
                "Route [{$routeName}] returned 404."
            );
        }
    }
}
