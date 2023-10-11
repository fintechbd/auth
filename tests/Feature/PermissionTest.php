<?php

use Illuminate\Support\Str;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

test('permission list', function () {
    getJson('/api/auth/permissions')->assertStatus(200);
});

test('permission create validation', function () {
    postJson('/api/auth/permissions', [
        'name' => Str::random(20),
        'guard_name' => 'web3',
    ])->assertStatus(422);
});

test('permission created', function () {
    postJson('/api/auth/permissions', [
        'name' => Str::random(20),
        'guard_name' => 'web',
    ])->assertStatus(201);
});

test('permission not found', function () {
    getJson('/api/auth/permissions/100')->assertStatus(404);
});

test('permission detail', function () {
    getJson('/api/auth/permissions/1')->assertStatus(200);
});

test('permission update validation', function () {

    putJson('/api/auth/permissions', [
        'name' => 'abcd',
        'guard_name' => 'web3',
    ])->assertStatus(422);
});

test('permission updated', function () {
    putJson('/api/auth/permissions/1', [
        'name' => Str::random(20),
    ])->assertStatus(200);
});

test('permission deleted', function () {
    deleteJson('/api/auth/permissions/1')->assertStatus(200);
});

test('permission restored', function () {
    postJson('/api/auth/permissions/1')->assertStatus(200);
});
