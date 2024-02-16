<?php

namespace Fintech\Auth\Seeders;

use Illuminate\Database\Seeder;
use Fintech\Auth\Facades\Auth;

class FavouriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = $this->data();

        foreach (array_chunk($data, 200) as $block) {
            set_time_limit(2100);
            foreach ($block as $entry) {
                Auth::favourite()->create($entry);
            }
        }
    }

    private function data()
    {
        return array();
    }
}
