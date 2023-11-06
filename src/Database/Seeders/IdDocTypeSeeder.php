<?php

namespace Fintech\Auth\Database\Seeders;

use Illuminate\Database\Seeder;
use Fintech\Auth\Facades\Auth;

class IdDocTypeSeeder extends Seeder
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
                Auth::idDocType()->create($entry);
            }
        }
    }

    private function data()
    {
        return array();
    }
}
