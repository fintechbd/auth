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
    }

    private function data()
    {
        return [
            [
                'id' => '1',
                'name' => 'Super Admin',
                'creator_id' => null,
                'editor_id' => null,
                'destroyer_id' => null,
                'created_at' => '2023-08-14 13:11:03',
                'updated_at' => '2023-08-14 13:11:03',
            ],
            [
                'id' => '2',
                'name' => 'Admin',
                'creator_id' => null,
                'editor_id' => null,
                'destroyer_id' => null,
                'created_at' => '2023-08-14 13:11:03',
                'updated_at' => '2023-08-14 13:11:03',
            ],
            [
                'id' => '3',
                'name' => 'Executive',
                'creator_id' => null,
                'editor_id' => null,
                'destroyer_id' => null,
                'created_at' => '2023-08-14 13:11:03',
                'updated_at' => '2023-08-14 13:11:03',
            ],
            [
                'id' => '4',
                'name' => 'Customer',
                'creator_id' => null,
                'editor_id' => null,
                'destroyer_id' => null,
                'created_at' => '2023-08-14 13:11:03',
                'updated_at' => '2023-08-14 13:11:03',
            ],
        ];
    }
}
