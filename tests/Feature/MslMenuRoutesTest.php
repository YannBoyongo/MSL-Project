<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class MslMenuRoutesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var list<string>
     */
    private array $menuRoutes = [
        'dashboard',
        'msl.statistics',
        'msl.markets.index',
        'msl.commodities.index',
        'msl.commodity-prices.index',
        'msl.commodity-prices.create',
        'msl.exchange-rates.index',
        'msl.exchange-rates.create',
        'msl.forex-bureaus.index',
        'msl.prices.compare',
        'msl.currency-converter',
        'msl.border-crossings.index',
        'msl.travel-documents.index',
        'msl.travel-requirements',
        'msl.claims.create',
        'msl.claims.index',
        'msl.claim-types.index',
        'msl.countries.index',
        'msl.languages.index',
        'msl.currencies.index',
        'msl.measurement-units.index',
        'msl.commodity-categories.index',
        'msl.users.index',
        'msl.roles.index',
        'msl.reports.index',
        'msl.reports.price-trends',
        'msl.reports.exchange-rate-trends',
        'msl.reports.claims',
        'msl.submissions.index',
        'msl.submissions.history',
        'msl.contact-persons.index',
        'msl.help',
        'msl.settings',
        'profile.edit',
        'msl.language',
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

    public function test_super_admin_can_access_all_msl_menu_pages(): void
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
