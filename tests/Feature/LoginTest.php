<?php

use Fintech\Auth\Facades\Auth;
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
    expect($login['message'])->toBe('The login id field is required. (and 2 more errors)');
});

test('Test that the login id field is present', function () {
    $login = postJson('/api/auth/login', [
        'login_id' => '',
        'password' => '12345678',
    ]);

    expect($login['message'])->toBe('The login id field is required.');
});

test('Test that the password field  is present', function () {
    $login = postJson('/api/auth/login', [
        'login_id' => '01700000001',
        'password' => '',
    ]);

    expect($login['message'])->toBe('The password field must be a string. (and 1 more error)');
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

    $permission = Auth::permission()->create([
        'name' => 'auth.login',
        'guard_name' => 'web',
    ]);
    $role = Auth::role()->create([
        'name' => 'user',
        'guard_name' => 'web',
        'permissions' => [$permission->getKey()]
    ]);
    Auth::user()->create([
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
