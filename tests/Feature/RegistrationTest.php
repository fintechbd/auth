<?php


use function Pest\Laravel\postJson;

test('Enter an email address with special characters in the email field when registration', function () {
    $registration = postJson('/api/auth/register', [
        "name" => "MT TECHNOLOGIES",
        "mobile" => "01700000001",
        "email" => "@dmin@mt-technologies.com",
        "login_id" => "01700000001",
        "pin" => "123456",
        "password" => "12345678",
        "app_version" => "0.0.1",
        "language" => "bd",
        "currency" => "BDT",
        "father_name" => "MT",
        "mother_name" => "TECHNOLOGIES",
        "gender" => "male",
        "marital_status" => "unmarried",
        "occupation" => "service",
        "source_of_income" => "salary",
        "id_type" => "passport",
        "id_no" => "1234567890",
        "id_issue_country" => "BANGLADESH",
        "id_expired_at" => "2030-12-31",
        "id_issue_at" => "2020-01-01",
        "date_of_birth" => "1985-02-19",
        "permanent_address" => "DHAKA",
        "city_id" => "1",
        "state_id" => "1",
        "country_id" => "18",
        "post_code" => "1100",
        "present_address" => "DHAKA",
        "present_city_id" => "1",
        "present_state_id" => "1",
        "present_country_id" => "18",
        "present_post_code" => "1100",
        "nationality" => "BANGLADESHI"
    ]);
    //dd($registration['message']);
    //$this->assertSame('The email field must be a valid email address.', $registration['message']);
    expect($registration['message'])->toBe('The email field must be a valid email address.');
    //assertStatus(201);
});
test('Enter an email address with spaces in the email field when registration', function () {
    $registration = postJson('/api/auth/register', [
        "name" => "MT TECHNOLOGIES",
        "mobile" => "01700000001",
        "email" => "ad min@mt-technologies.com",
        "login_id" => "01700000001",
        "pin" => "123456",
        "password" => "12345678",
        "app_version" => "0.0.1",
        "language" => "bd",
        "currency" => "BDT",
        "father_name" => "MT",
        "mother_name" => "TECHNOLOGIES",
        "gender" => "male",
        "marital_status" => "unmarried",
        "occupation" => "service",
        "source_of_income" => "salary",
        "id_type" => "passport",
        "id_no" => "1234567890",
        "id_issue_country" => "BANGLADESH",
        "id_expired_at" => "2030-12-31",
        "id_issue_at" => "2020-01-01",
        "date_of_birth" => "1985-02-19",
        "permanent_address" => "DHAKA",
        "city_id" => "1",
        "state_id" => "1",
        "country_id" => "18",
        "post_code" => "1100",
        "present_address" => "DHAKA",
        "present_city_id" => "1",
        "present_state_id" => "1",
        "present_country_id" => "18",
        "present_post_code" => "1100",
        "nationality" => "BANGLADESHI"
    ]);
    //dd($registration['message']);
    //$this->assertSame('The email field must be a valid email address.', $registration['message']);
    expect($registration['message'])->toBe('The email field must be a valid email address.');
    //assertStatus(201);
});
test('Leave the email field blank when registration', function () {
    $registration = postJson('/api/auth/register', [
        "name" => "MT TECHNOLOGIES",
        "mobile" => "01700000001",
        "email" => "",
        "login_id" => "01700000001",
        "pin" => "123456",
        "password" => "12345678",
        "app_version" => "0.0.1",
        "language" => "bd",
        "currency" => "BDT",
        "father_name" => "MT",
        "mother_name" => "TECHNOLOGIES",
        "gender" => "male",
        "marital_status" => "unmarried",
        "occupation" => "service",
        "source_of_income" => "salary",
        "id_type" => "passport",
        "id_no" => "1234567890",
        "id_issue_country" => "BANGLADESH",
        "id_expired_at" => "2030-12-31",
        "id_issue_at" => "2020-01-01",
        "date_of_birth" => "1985-02-19",
        "permanent_address" => "DHAKA",
        "city_id" => "1",
        "state_id" => "1",
        "country_id" => "18",
        "post_code" => "1100",
        "present_address" => "DHAKA",
        "present_city_id" => "1",
        "present_state_id" => "1",
        "present_country_id" => "18",
        "present_post_code" => "1100",
        "nationality" => "BANGLADESHI"
    ]);
    //dd($registration['message']);
    //$this->assertSame('The email field must be a valid email address.', $registration['message']);
    expect($registration['message'])->toBe('The email field is required.');
    //assertStatus(201);
});
test('The email field must be a valid email address when registration', function () {
    $registration = postJson('/api/auth/register', [
        "name" => "MT TECHNOLOGIES",
        "mobile" => "01700000001",
        "email" => "admin@mt-technologies",
        "login_id" => "01700000001",
        "pin" => "123456",
        "password" => "12345678",
        "app_version" => "0.0.1",
        "language" => "bd",
        "currency" => "BDT",
        "father_name" => "MT",
        "mother_name" => "TECHNOLOGIES",
        "gender" => "male",
        "marital_status" => "unmarried",
        "occupation" => "service",
        "source_of_income" => "salary",
        "id_type" => "passport",
        "id_no" => "1234567890",
        "id_issue_country" => "BANGLADESH",
        "id_expired_at" => "2030-12-31",
        "id_issue_at" => "2020-01-01",
        "date_of_birth" => "1985-02-19",
        "permanent_address" => "DHAKA",
        "city_id" => "1",
        "state_id" => "1",
        "country_id" => "18",
        "post_code" => "1100",
        "present_address" => "DHAKA",
        "present_city_id" => "1",
        "present_state_id" => "1",
        "present_country_id" => "18",
        "present_post_code" => "1100",
        "nationality" => "BANGLADESHI"
    ]);
    //$this->assertSame('The email field must be a valid email address.', $registration['message']);
    expect($registration['message'])->toBe('The email field must be a valid email address.');
    //assertStatus(201);
});
test('registration', function () {
    postJson('/api/auth/register', [
            "name" => "MT TECHNOLOGIES",
            "mobile" => "01700000001",
            "email" => "admin@mt-technologies.com",
            "login_id" => "01700000001",
            "pin" => "123456",
            "password" => "12345678",
            "app_version" => "0.0.1",
            "language" => "bd",
            "currency" => "BDT",
            "father_name" => "MT",
            "mother_name" => "TECHNOLOGIES",
            "gender" => "male",
            "marital_status" => "unmarried",
            "occupation" => "service",
            "source_of_income" => "salary",
            "id_type" => "passport",
            "id_no" => "1234567890",
            "id_issue_country" => "BANGLADESH",
            "id_expired_at" => "2030-12-31",
            "id_issue_at" => "2020-01-01",
            "date_of_birth" => "1985-02-19",
            "permanent_address" => "DHAKA",
            "city_id" => "1",
            "state_id" => "1",
            "country_id" => "18",
            "post_code" => "1100",
            "present_address" => "DHAKA",
            "present_city_id" => "1",
            "present_state_id" => "1",
            "present_country_id" => "18",
            "present_post_code" => "1100",
            "nationality" => "BANGLADESHI"
        ])->assertStatus(201);
});
