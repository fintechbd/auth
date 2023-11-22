<?php

namespace Fintech\Auth\Seeders;

use Fintech\Auth\Facades\Auth;
use Fintech\Core\Enums\Auth\SystemRole;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->data() as $role) {
            Auth::role()->create($role);
        }

        Auth::role()->update(1, [
            'permissions' => Auth::permission()->list()->pluck('id')->toArray()
        ]);
    }

    private function data()
    {
        return [
            [
                'id' => '1',
                'name' => SystemRole::SuperAdmin->value,
            ],
            [
                'id' => '2',
                'name' => SystemRole::MasterUser->value,
            ],
            [
                'id' => '3',
                'name' => 'Admin',
            ],
            [
                'id' => '4',
                'name' => 'Executive',
            ],
            [
                'id' => '5',
                'name' => 'Partner'
            ],
            [
                'id' => '6',
                'name' => 'Agent'
            ],
            [
                'id' => '7',
                'name' => 'Customer',
            ],
        ];
    }
}
