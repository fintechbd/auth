<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

define('BASE_URL', 'http://devstarter.test/api/auth');

test('permission list', function () {
    $response = Http::get(BASE_URL.'/permissions');
    expect($response->status())->toEqual(200);
});

test('permission create validation', function () {

    $response = Http::post(BASE_URL.'/permissions', [
        'name' => Str::random(20),
        'guard_name' => 'web3'
    ]);
    expect($response->status())->toEqual(422);
});

test('permission created', function () {

    $response = Http::post(BASE_URL.'/permissions', [
        'name' => Str::random(20),
        'guard_name' => 'web'
    ]);
    expect($response->status())->toEqual(201);
});

test('permission not found', function () {
    $response = Http::get(BASE_URL.'/permissions/100');
    expect($response->status())->toEqual(404);
});

test('permission detail', function () {
    $response = Http::get(BASE_URL.'/permissions/1');
    expect($response->status())->toEqual(200);
});

test('permission update validation', function () {

    $response = Http::post(BASE_URL.'/permissions', [
        'name' => 'abcd',
        'guard_name' => 'web3'
    ]);
    expect($response->status())->toEqual(422);
});

test('permission updated', function () {
    $response = Http::put(BASE_URL.'/permissions/1', [
        'name' => Str::random(20),
    ]);
    expect($response->status())->toEqual(200);
});

test('permission deleted', function () {
    $response = Http::delete(BASE_URL.'/permissions/1');
    expect($response->status())->toEqual(200);
});

test('permission restored', function () {
    $response = Http::delete(BASE_URL.'/permissions/1');
    expect($response->status())->toEqual(200);
});
