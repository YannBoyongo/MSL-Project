<?php

namespace Tests\Feature;

use App\Models\Country;
use App\Models\Market;
use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MslFilterTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleAndPermissionSeeder::class);
    }

    public function test_country_filter_can_be_cleared(): void
    {
        $country = Country::query()->create([
            'name' => 'Test Country',
            'iso_code' => 'TC',
            'phone_code' => '+000',
            'is_active' => true,
        ]);

        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->assignRole('super-admin');
        $user->countries()->attach($country->id);

        $this->actingAs($user)
            ->get(route('msl.markets.index', ['country_id' => $country->id]))
            ->assertOk();

        $this->actingAs($user)
            ->get(route('msl.markets.index', ['country_id' => '']))
            ->assertOk();
    }

    public function test_search_filter_preserves_country_filter(): void
    {
        $country = Country::query()->create([
            'name' => 'Filter Country',
            'iso_code' => 'FC',
            'phone_code' => '+001',
            'is_active' => true,
        ]);

        Market::query()->create([
            'country_id' => $country->id,
            'name' => 'Central Market',
            'city' => 'Capital',
            'is_active' => true,
        ]);

        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->assignRole('super-admin');
        $user->countries()->attach($country->id);

        $this->actingAs($user)
            ->get(route('msl.markets.index', ['country_id' => $country->id, 'search' => 'Central']))
            ->assertOk()
            ->assertSee('Central Market');
    }

    public function test_commodity_prices_default_to_today(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->assignRole('super-admin');

        $this->actingAs($user)
            ->get(route('msl.commodity-prices.index'))
            ->assertOk()
            ->assertSee(today()->format('Y-m-d'), false);
    }

    public function test_commodity_prices_can_show_all_dates(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->assignRole('super-admin');

        $this->actingAs($user)
            ->get(route('msl.commodity-prices.index', ['price_date' => '']))
            ->assertOk();
    }
}
