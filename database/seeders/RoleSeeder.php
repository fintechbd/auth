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
        $permissions = Auth::permission(['paginate' => false]);

        foreach ($this->data() as $role) {

            if(!isset($role['guard_name'])) {
                $role['guard_name'] = 'web';
            }

            if (isset($role['permissions'])) {
                if (is_string($role['permissions']) && $role['permissions'] = "all") {
                    $role['permissions'] = $permissions->pluck('id')->toArray();
                }
                else if (is_array($role['permissions'])) {
                    $ids = $permissions->whereIn('name', $role['permissions'])->pluck('id')->toArray();
                    $role['permissions'] = $ids;
                }
                else {unset($role['permissions']);}
            }

            Auth::role()->create($role);
        }
    }

    private function data()
    {
        $path = file_exists(database_path('seeders/roles.json'))
            ? database_path('seeders' . DIRECTORY_SEPARATOR . 'roles.json')
            : __DIR__ . DIRECTORY_SEPARATOR . 'roles.json';

        return json_decode(file_get_contents($path), true);
    }
}
