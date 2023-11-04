<?php

namespace Fintech\Auth\Seeders;

use Fintech\Auth\Facades\Auth;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->data() as $user) {
            if($entry = Auth::user()->create($user['user'])) {
                Auth::profile()->create($entry->getKey(), $user['profile']);
            }
        }
    }


    private function data()
    {
        return [
            [
                'user' => [
                    "parent_id" => null,
                    "name" => "Hafijul Islam",
                    "mobile" => "8801600000001",
                    "email" => "hafijul233@gmail.com",
                    "login_id" => "01600000001",
                    "password" => "12345678",
                    "pin" => "123456",
                    "language" => "en",
                    "currency" => "BDT",
                    "app_version" => "1.0",
                    "fcm_token" => Str::random(40),
                    "roles" => [1],
                ],
                'profile' => [
                    "father_name" => "Mustak Ahmed",
                    "mother_name" => "Hamida Begum",
                    "gender" => "male",
                    "marital_status" => "unmarried",
                    "occupation" => "service",
                    "source_of_income" => "salary",
                    "id_type" => "passport",
                    "id_no" => "12345678",
                    "id_issue_country" => "Bangladesh",
                    "id_expired_at" => now()->addYears(5)->format('Y-m-d'),
                    "id_issue_at" => now()->format('Y-m-d'),
                    "profile_photo" => null,
                    "scan" => null,
                    "scan_1" => null,
                    "scan_2" => null,
                    "date_of_birth" => now()->subYears(25)->format('Y-m-d'),
                    "permanent_address" => "Savar, Dhaka",
                    "city_id" => "1",
                    "state_id" => "1",
                    "country_id" => "1",
                    "post_code" => "1207",
                    "present_address" => "Mohammadpur",
                    "present_city_id" => "1",
                    "present_state_id" => "1",
                    "present_country_id" => "1",
                    "present_post_code" => "1234",
                    "note" => "Testing",
                    "nationality" => "Bangladeshi"
                ]
            ],
            [
                'user' => [
                    "parent_id" => null,
                    "name" => "Ariful Islam",
                    "mobile" => "8801600000002",
                    "email" => "mah.shamim@gmail.com",
                    "login_id" => "01600000002",
                    "password" => "12345678",
                    "pin" => "123456",
                    "app_version" => "1.0",
                    "fcm_token" => Str::random(40),
                    "language" => "en",
                    "currency" => "BDT",
                    "roles" => [1],
                ],
                'profile' => [
                    "father_name" => "Mustak Ahmed",
                    "mother_name" => "Hamida Begum",
                    "gender" => "male",
                    "marital_status" => "unmarried",
                    "occupation" => "service",
                    "source_of_income" => "salary",
                    "id_type" => "passport",
                    "id_no" => "12345678",
                    "id_issue_country" => "Bangladesh",
                    "id_expired_at" => now()->addYears(5)->format('Y-m-d'),
                    "id_issue_at" => now()->format('Y-m-d'),
                    "profile_photo" => null,
                    "scan" => null,
                    "scan_1" => null,
                    "scan_2" => null,
                    "date_of_birth" => now()->subYears(25)->format('Y-m-d'),
                    "permanent_address" => "Savar, Dhaka",
                    "city_id" => "1",
                    "state_id" => "1",
                    "country_id" => "1",
                    "post_code" => "1207",
                    "present_address" => "Mohammadpur",
                    "present_city_id" => "1",
                    "present_state_id" => "1",
                    "present_country_id" => "1",
                    "present_post_code" => "1234",
                    "note" => "Testing",
                    "nationality" => "Bangladeshi"
                ]
            ],
            [
                'user' => [
                    "parent_id" => null,
                    "name" => "Tarif Islam",
                    "mobile" => "8801600000003",
                    "email" => "tarif@gmail.com",
                    "login_id" => "01600000003",
                    "password" => "12345678",
                    "pin" => "123456",
                    "app_version" => "1.0",
                    "fcm_token" => Str::random(40),
                    "language" => "en",
                    "currency" => "BDT",
                    "roles" => [1]
                ],
                'profile' => [
                    "father_name" => "Mustak Ahmed",
                    "mother_name" => "Hamida Begum",
                    "gender" => "male",
                    "marital_status" => "unmarried",
                    "occupation" => "service",
                    "source_of_income" => "salary",
                    "id_type" => "passport",
                    "id_no" => "12345678",
                    "id_issue_country" => "Bangladesh",
                    "id_expired_at" => now()->addYears(5)->format('Y-m-d'),
                    "id_issue_at" => now()->format('Y-m-d'),
                    "profile_photo" => null,
                    "scan" => null,
                    "scan_1" => null,
                    "scan_2" => null,
                    "date_of_birth" => now()->subYears(25)->format('Y-m-d'),
                    "permanent_address" => "Savar, Dhaka",
                    "city_id" => "1",
                    "state_id" => "1",
                    "country_id" => "1",
                    "post_code" => "1207",
                    "present_address" => "Mohammadpur",
                    "present_city_id" => "1",
                    "present_state_id" => "1",
                    "present_country_id" => "1",
                    "present_post_code" => "1234",
                    "note" => "Testing",
                    "nationality" => "Bangladeshi"
                ]
            ]
        ];

    }
}
