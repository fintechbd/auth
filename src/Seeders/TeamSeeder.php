<?php

namespace Fintech\Auth\Seeders;

use Fintech\Auth\Facades\Auth;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->data() as $team) {
            Auth::team()->create($team);
        }
    }

    private function data()
    {
        return [
            [
                'id' => '1',
                'name' => 'Bangladesh',
                'creator_id' => null,
                'editor_id' => null,
                'destroyer_id' => null,
                'created_at' => '2023-08-14 13:11:03',
                'updated_at' => '2023-08-14 13:11:03',
            ],
            [
                'id' => '2',
                'name' => 'India',
                'creator_id' => null,
                'editor_id' => null,
                'destroyer_id' => null,
                'created_at' => '2023-08-14 13:11:03',
                'updated_at' => '2023-08-14 13:11:03',
            ],
            [
                'id' => '3',
                'name' => 'China',
                'creator_id' => null,
                'editor_id' => null,
                'destroyer_id' => null,
                'created_at' => '2023-08-14 13:11:03',
                'updated_at' => '2023-08-14 13:11:03',
            ],
            [
                'id' => '4',
                'name' => 'Malaysia',
                'creator_id' => null,
                'editor_id' => null,
                'destroyer_id' => null,
                'created_at' => '2023-08-14 13:11:03',
                'updated_at' => '2023-08-14 13:11:03',
            ],
            [
                'id' => '5',
                'name' => 'Philippines',
                'creator_id' => null,
                'editor_id' => null,
                'destroyer_id' => null,
                'created_at' => '2023-08-14 13:11:03',
                'updated_at' => '2023-08-14 13:11:03',
            ],
        ];
    }
}
