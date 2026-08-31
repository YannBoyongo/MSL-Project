<?php

namespace Tests\Feature;

use App\Models\Claim;
use App\Models\ClaimType;
use App\Models\Country;
use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MslAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleAndPermissionSeeder::class);
    }

    public function test_super_admin_can_access_dashboard(): void
    {
        $user = User::factory()->create();
        $user->assignRole('super-admin');

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertOk();
    }

    public function test_trader_cannot_access_user_management(): void
    {
        $user = User::factory()->create();
        $user->assignRole('trader');

        $response = $this->actingAs($user)->get(route('msl.users.index'));

        $response->assertForbidden();
    }

    public function test_data_collector_can_access_price_creation(): void
    {
        $user = User::factory()->create();
        $user->assignRole('data-collector');

        $response = $this->actingAs($user)->get(route('msl.commodity-prices.create'));

        $response->assertOk();
    }

    public function test_data_collector_cannot_access_user_management(): void
    {
        $user = User::factory()->create();
        $user->assignRole('data-collector');

        $response = $this->actingAs($user)->get(route('msl.users.index'));

        $response->assertForbidden();
    }

    public function test_country_admin_cannot_access_unauthorized_country_market(): void
    {
        $allowedCountry = Country::query()->create([
            'name' => 'Allowed',
            'iso_code' => 'ALW',
            'phone_code' => '+000',
            'is_active' => true,
        ]);

        $deniedCountry = Country::query()->create([
            'name' => 'Denied',
            'iso_code' => 'DEN',
            'phone_code' => '+001',
            'is_active' => true,
        ]);

        $user = User::factory()->create();
        $user->assignRole('country-admin');
        $user->countries()->attach($allowedCountry->id);

        $response = $this->actingAs($user)->get(route('msl.markets.index', [
            'country_id' => $deniedCountry->id,
        ]));

        $response->assertForbidden();
    }

    public function test_trader_cannot_view_another_traders_claim(): void
    {
        $country = Country::query()->create([
            'name' => 'Test Country',
            'iso_code' => 'TST',
            'phone_code' => '+002',
            'is_active' => true,
        ]);

        $traderA = User::factory()->create();
        $traderA->assignRole('trader');
        $traderA->countries()->attach($country->id);

        $traderB = User::factory()->create();
        $traderB->assignRole('trader');
        $traderB->countries()->attach($country->id);

        $claimType = ClaimType::query()->create(['code' => 'OTHER', 'is_active' => true]);

        $claim = Claim::query()->create([
            'reference_number' => 'CLM-2026-000099',
            'user_id' => $traderB->id,
            'country_id' => $country->id,
            'claim_type_id' => $claimType->id,
            'title' => 'Test claim',
            'description' => 'Private claim',
            'status' => 'submitted',
        ]);

        $response = $this->actingAs($traderA)->get(route('msl.claims.show', $claim));

        $response->assertForbidden();
    }

    public function test_trader_can_create_claim(): void
    {
        $user = User::factory()->create();
        $user->assignRole('trader');

        $response = $this->actingAs($user)->get(route('msl.claims.create'));

        $response->assertOk();
    }

    public function test_guest_is_redirected_from_dashboard(): void
    {
        $response = $this->get(route('dashboard'));

        $response->assertRedirect(route('login'));
    }
}
