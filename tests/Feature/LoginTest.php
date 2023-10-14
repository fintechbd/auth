<?php

use function Pest\Laravel\postJson;

test('login failed', function () {
    postJson('/api/auth/permissions', [
        'login_id' => '01600000001',
        'password' => '12345678',
    ])->assertStatus(422);
});

test('Test that the login when login id and password blank', function () {
    $login = postJson('/api/auth/login', [
        'login_id' => '',
        'password' => '',
    ]);
    //$this->assertSame('The email field must be a valid email address.', $login['message']);
    expect($login['message'])->toBe('The login id field is required. (and 1 more error)');
    //assertStatus(201);
});

test('Test that the login id field is present', function () {
    $login = postJson('/api/auth/login', [
        'login_id' => '',
        'password' => '12345678',
    ]);
    //$this->assertSame('The email field must be a valid email address.', $login['message']);
    expect($login['message'])->toBe('The login id field is required.');
    //assertStatus(201);
});

test('Test that the password field  is present', function () {
    $login = postJson('/api/auth/login', [
        'login_id' => '01700000001',
        'password' => '',
    ]);
    //$this->assertSame('The email field must be a valid email address.', $login['message']);
    expect($login['message'])->toBe('The password field is required.');
    //assertStatus(201);
});

test('Test that the password field correctly validates input when 6 characters', function () {
    $login = postJson('/api/auth/login', [
        'login_id' => '01700000001',
        'password' => '123456',
    ]);
    //$this->assertSame('The email field must be a valid email address.', $login['message']);
    expect($login['message'])->toBe('The password field must be at least 8 characters.');
    //assertStatus(201);
});

test('Test that the password field correctly validates input when submitting the form', function () {

    $permission = \Fintech\Auth\Facades\Auth::permission()->create([
        'name' => 'auth.login',
        'guard_name' => 'web',
    ]);
    $role = \Fintech\Auth\Facades\Auth::role()->create([
        'name' => 'user',
        'guard_name' => 'web',
        'permissions' => [$permission->getKey()]
    ]);
    \Fintech\Auth\Facades\Auth::user()->create([
        "name" => "MT TECHNOLOGIES",
        "mobile" => "01700000001",
        "email" => "admin@mt-technologies.com",
        "login_id" => "01700000001",
        "pin" => ("123456"),
        "password" => ("12345678"),
        "app_version" => "0.0.1",
        "language" => "bd",
        "currency" => "BDT",
        "roles" => [$role->getKey()]
    ]);

    $login = postJson('/api/auth/login', [
        'login_id' => '01700000001',
        'password' => '12345678',
    ]);
    //$this->assertSame('The email field must be a valid email address.', $login['message']);
    expect($login['message'])->toBe('Login successful.');
    //assertStatus(201);
});
