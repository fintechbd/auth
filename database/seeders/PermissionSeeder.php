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
        $path = file_exists(database_path('seeders/permissions.json'))
            ? database_path('seeders' . DIRECTORY_SEPARATOR . 'permissions.json')
            : __DIR__ . DIRECTORY_SEPARATOR . 'permissions.json';

        return json_decode(file_get_contents($path), true);
    }
}
