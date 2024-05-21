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
                'name' => 'auth.forgot-password',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'auth.reset-password',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'auth.request-otp',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'auth.verify-otp',
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
                'name' => 'auth.users.restore',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'auth.users.reset-password-pin',
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
                'name' => 'auth.settings.index',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'auth.settings.store',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'auth.audits.index',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'auth.audits.show',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'auth.audits.destroy',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'auth.id-doc-types.index',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'auth.id-doc-types.store',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'auth.id-doc-types.show',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'auth.id-doc-types.update',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'auth.id-doc-types.destroy',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'auth.id-doc-types.restore',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'banco.banks.index',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'banco.banks.store',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'banco.banks.show',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'banco.banks.update',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'banco.banks.destroy',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'banco.banks.restore',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'banco.bank-branches.index',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'banco.bank-branches.store',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'banco.bank-branches.show',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'banco.bank-branches.update',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'banco.bank-branches.destroy',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'banco.bank-branches.restore',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'banco.beneficiaries.index',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'banco.beneficiaries.store',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'banco.beneficiaries.show',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'banco.beneficiaries.update',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'banco.beneficiaries.destroy',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'banco.beneficiaries.restore',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'banco.beneficiary-types.index',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'banco.beneficiary-types.store',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'banco.beneficiary-types.show',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'banco.beneficiary-types.update',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'banco.beneficiary-types.destroy',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'banco.beneficiary-types.restore',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.service-settings.types',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.service-settings.type-fields',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.service-settings.index',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.service-settings.store',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.service-settings.show',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.service-settings.update',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.service-settings.destroy',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.service-settings.restore',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.service-types.index',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.service-types.store',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.service-types.show',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.service-types.update',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.service-types.destroy',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.service-types.restore',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.services.index',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.services.store',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.services.show',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.services.update',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.services.destroy',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.services.restore',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.service-states.index',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.service-states.store',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.service-states.show',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.service-states.update',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.service-states.destroy',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.service-states.restore',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.service-packages.index',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.service-packages.store',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.service-packages.show',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.service-packages.update',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.service-packages.destroy',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.service-packages.restore',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.charge-break-downs.index',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.charge-break-downs.store',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.charge-break-downs.show',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.charge-break-downs.update',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.charge-break-downs.destroy',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.charge-break-downs.restore',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.package-top-charts.index',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.package-top-charts.store',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.package-top-charts.show',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.package-top-charts.update',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.package-top-charts.destroy',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.package-top-charts.restore',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.service-vendors.index',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.service-vendors.store',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.service-vendors.show',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.service-vendors.update',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.service-vendors.destroy',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'business.service-vendors.restore',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'core.settings.index',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'core.settings.store',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'core.settings.show',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'core.settings.update',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'core.settings.destroy',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'core.settings.restore',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'core.configurations.show',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'core.configurations.update',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'core.configurations.destroy',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'core.jobs.index',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'core.jobs.store',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'core.jobs.show',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'core.jobs.update',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'core.jobs.destroy',
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
                'name' => 'metadata.regions.restore',
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
                'name' => 'metadata.subregions.restore',
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
                'name' => 'metadata.countries.restore',
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
                'name' => 'metadata.states.restore',
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
                'name' => 'metadata.cities.restore',
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
                'name' => 'metadata.fund-sources.restore',
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
                'name' => 'metadata.occupations.restore',
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
                'name' => 'metadata.relations.restore',
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
            ),
            array(
                'name' => 'metadata.remittance-purposes.restore',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.languages.index',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.languages.store',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.languages.show',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.languages.update',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.languages.destroy',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'metadata.languages.restore',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'promo.promotions.promotion-types',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'promo.promotions.index',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'promo.promotions.store',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'promo.promotions.show',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'promo.promotions.update',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'promo.promotions.destroy',
                'guard_name' => 'web',
            ),
            array(
                'name' => 'promo.promotions.restore',
                'guard_name' => 'web',
            )
        );

    }
}
