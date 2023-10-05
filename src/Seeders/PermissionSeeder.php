<?php

namespace Fintech\Auth\Seeders;

use Fintech\Auth\Facades\Auth;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->data() as $permission) {
            Auth::permission()->create($permission);
        }
    }

    private function data()
    {
        return [
            [
                'name' => 'auth.register',
                'guard_name' => 'web',
            ],
            [
                'name' => 'auth.login',
                'guard_name' => 'web',
            ],
            [
                'name' => 'auth.logout',
                'guard_name' => 'web',
            ],
            [
                'name' => 'auth.users.index',
                'guard_name' => 'web',
            ],
            [
                'name' => 'auth.users.store',
                'guard_name' => 'web',
            ],
            [
                'name' => 'auth.users.show',
                'guard_name' => 'web',
            ],
            [
                'name' => 'auth.users.update',
                'guard_name' => 'web',
            ],
            [
                'name' => 'auth.users.destroy',
                'guard_name' => 'web',
            ],
            [
                'name' => 'auth.roles.index',
                'guard_name' => 'web',
            ],
            [
                'name' => 'auth.roles.store',
                'guard_name' => 'web',
            ],
            [
                'name' => 'auth.roles.show',
                'guard_name' => 'web',
            ],
            [
                'name' => 'auth.roles.update',
                'guard_name' => 'web',
            ],
            [
                'name' => 'auth.roles.destroy',
                'guard_name' => 'web',
            ],
            [
                'name' => 'auth.roles.restore',
                'guard_name' => 'web',
            ],
            [
                'name' => 'auth.permissions.index',
                'guard_name' => 'web',
            ],
            [
                'name' => 'auth.permissions.store',
                'guard_name' => 'web',
            ],
            [
                'name' => 'auth.permissions.show',
                'guard_name' => 'web',
            ],
            [
                'name' => 'auth.permissions.update',
                'guard_name' => 'web',
            ],
            [
                'name' => 'auth.permissions.destroy',
                'guard_name' => 'web',
            ],
            [
                'name' => 'auth.permissions.restore',
                'guard_name' => 'web',
            ],
            [
                'name' => 'auth.teams.index',
                'guard_name' => 'web',
            ],
            [
                'name' => 'auth.teams.store',
                'guard_name' => 'web',
            ],
            [
                'name' => 'auth.teams.show',
                'guard_name' => 'web',
            ],
            [
                'name' => 'auth.teams.update',
                'guard_name' => 'web',
            ],
            [
                'name' => 'auth.teams.destroy',
                'guard_name' => 'web',
            ],
            [
                'name' => 'auth.teams.restore',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.regions.index',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.regions.store',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.regions.show',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.regions.update',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.regions.destroy',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.subregions.index',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.subregions.store',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.subregions.show',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.subregions.update',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.subregions.destroy',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.countries.index',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.countries.store',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.countries.show',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.countries.update',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.countries.destroy',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.states.index',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.states.store',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.states.show',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.states.update',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.states.destroy',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.cities.index',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.cities.store',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.cities.show',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.cities.update',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.cities.destroy',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.banks.index',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.banks.store',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.banks.show',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.banks.update',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.banks.destroy',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.bank-branches.index',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.bank-branches.store',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.bank-branches.show',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.bank-branches.update',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.bank-branches.destroy',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.fund-sources.index',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.fund-sources.store',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.fund-sources.show',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.fund-sources.update',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.fund-sources.destroy',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.occupations.index',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.occupations.store',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.occupations.show',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.occupations.update',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.occupations.destroy',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.relations.index',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.relations.store',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.relations.show',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.relations.update',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.relations.destroy',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.remittance-purposes.index',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.remittance-purposes.store',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.remittance-purposes.show',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.remittance-purposes.update',
                'guard_name' => 'web',
            ],
            [
                'name' => 'metadata.remittance-purposes.destroy',
                'guard_name' => 'web',
            ],
        ];

    }
}
