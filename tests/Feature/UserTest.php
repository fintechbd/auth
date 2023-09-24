<?php

use Illuminate\Support\Facades\Http;

define('BASE_URL', 'http://devstarter.test/api/v1/auth');

test('user list', function () {
    $response = Http::get(BASE_URL . '/users');
    expect($response->status())->toEqual(200);
});

test('user created', function () {

    $response = Http::post(BASE_URL . '/users', [
        'parent_id' => null,
        'name' => 'Test',
        'mobile' => '01689553434',
        'email' => 'admin@gmail.com',
        'loginid' => '123456' . mt_rand(1000, 9999),
        'password' => '123456789',
        'pin' => '1234',
        'status' => 'ACTIVE',
        'language' => 'en',
        'currency' => 'BDT'
    ]);
    expect($response->status())->toEqual(201);
});

test('user detail', function () {
    $response = Http::get(BASE_URL . '/users/1');
    expect($response->status())->toEqual(200);
});

test('user updated', function () {
    $response = Http::put(BASE_URL . '/users/1', [
        'name' => 'Hafijul Islam',
    ]);
    expect($response->status())->toEqual(202);
});

test('user deleted', function () {
    $response = Http::delete(BASE_URL . '/users/1');
    expect($response->status())->toEqual(200);
});
