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
        return array(
            array(
                'name' => 'auth.register',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'auth.login',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'auth.logout',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'auth.users.index',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'auth.users.store',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'auth.users.show',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'auth.users.update',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'auth.users.destroy',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'auth.roles.index',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'auth.roles.store',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'auth.roles.show',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'auth.roles.update',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'auth.roles.destroy',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'auth.roles.restore',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'auth.permissions.index',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'auth.permissions.store',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'auth.permissions.show',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'auth.permissions.update',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'auth.permissions.destroy',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'auth.permissions.restore',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'auth.teams.index',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'auth.teams.store',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'auth.teams.show',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'auth.teams.update',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'auth.teams.destroy',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'auth.teams.restore',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.regions.index',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.regions.store',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.regions.show',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.regions.update',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.regions.destroy',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.subregions.index',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.subregions.store',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.subregions.show',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.subregions.update',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.subregions.destroy',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.countries.index',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.countries.store',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.countries.show',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.countries.update',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.countries.destroy',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.states.index',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.states.store',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.states.show',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.states.update',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.states.destroy',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.cities.index',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.cities.store',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.cities.show',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.cities.update',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.cities.destroy',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.banks.index',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.banks.store',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.banks.show',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.banks.update',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.banks.destroy',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.bank-branches.index',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.bank-branches.store',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.bank-branches.show',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.bank-branches.update',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.bank-branches.destroy',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.fund-sources.index',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.fund-sources.store',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.fund-sources.show',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.fund-sources.update',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.fund-sources.destroy',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.occupations.index',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.occupations.store',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.occupations.show',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.occupations.update',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.occupations.destroy',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.relations.index',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.relations.store',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.relations.show',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.relations.update',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.relations.destroy',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.remittance-purposes.index',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.remittance-purposes.store',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.remittance-purposes.show',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.remittance-purposes.update',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.remittance-purposes.destroy',
                'guard_name' => 'web',
            )
        );

    }
}
