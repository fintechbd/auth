<?php

namespace Fintech\Auth\Seeders;

use Fintech\Auth\Facades\Auth;
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
                'name' => 'Super Admin',
            ],
            [
                'id' => '2',
                'name' => 'Admin',
            ],
            [
                'id' => '3',
                'name' => 'Executive',
            ],
            [
                'id' => '4',
                'name' => 'Partner'
            ],
            [
                'id' => '5',
                'name' => 'Agent'
            ],
            [
                'id' => '6',
                'name' => 'Customer',
            ],
        ];
    }
}
