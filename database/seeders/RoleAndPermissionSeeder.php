<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * @var list<string>
     */
    private array $permissions = [
        'countries.view',
        'countries.manage',
        'markets.view',
        'markets.create',
        'markets.update',
        'markets.delete',
        'commodities.view',
        'commodities.create',
        'commodities.update',
        'commodities.delete',
        'prices.view',
        'prices.create',
        'prices.update',
        'prices.delete',
        'exchange_rates.view',
        'exchange_rates.create',
        'exchange_rates.update',
        'claims.create',
        'claims.view',
        'claims.review',
        'claims.resolve',
        'travel_documents.view',
        'travel_documents.manage',
        'users.view',
        'users.manage',
        'roles.manage',
        'reports.view',
    ];

    /**
     * @var list<string>
     */
    private array $roles = [
        'super-admin',
        'country-admin',
        'data-collector',
        'market-officer',
        'border-officer',
        'claim-officer',
        'trader',
    ];

    /**
     * @var array<string, list<string>>
     */
    private array $rolePermissions = [
        'super-admin' => [], // all permissions assigned below
        'country-admin' => [
            'countries.view', 'markets.view', 'markets.create', 'markets.update',
            'commodities.view', 'prices.view', 'prices.create', 'exchange_rates.view',
            'exchange_rates.create', 'claims.view', 'claims.review', 'travel_documents.view',
            'travel_documents.manage', 'users.view', 'reports.view',
        ],
        'data-collector' => [
            'prices.view', 'prices.create', 'exchange_rates.view', 'exchange_rates.create',
        ],
        'market-officer' => [
            'markets.view', 'commodities.view', 'prices.view', 'prices.create',
        ],
        'border-officer' => [
            'travel_documents.view', 'claims.view', 'claims.review',
        ],
        'claim-officer' => [
            'claims.view', 'claims.review', 'claims.resolve',
        ],
        'trader' => [
            'prices.view', 'exchange_rates.view', 'travel_documents.view',
            'claims.create', 'claims.view',
        ],
    ];

    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissionModels = [];
        foreach ($this->permissions as $permission) {
            $permissionModels[$permission] = Permission::findOrCreate($permission, 'web');
        }

        foreach ($this->roles as $roleName) {
            $role = Role::findOrCreate($roleName, 'web');

            if ($roleName === 'super-admin') {
                $role->syncPermissions(array_values($permissionModels));

                continue;
            }

            $names = $this->rolePermissions[$roleName] ?? [];
            $role->syncPermissions(
                collect($names)->map(fn (string $name) => $permissionModels[$name])->all()
            );
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
