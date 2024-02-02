<?php

namespace Fintech\Auth\Seeders;

use Fintech\Core\Exceptions\UpdateOperationException;
use Fintech\Core\Facades\Core;
use Illuminate\Database\Seeder;

class RoleServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws UpdateOperationException
     */
    public function run(): void
    {
        if (Core::packageExists('Business')) {
            $roles = [1, 3, 7];
            $services = \Fintech\Business\Facades\Business::service()->list()->pluck('id')->toArray();
            foreach ($roles as $roleId) {
                \Fintech\Auth\Facades\Auth::role()->update($roleId, ['services' => $services]);
            }
        }
    }
}
