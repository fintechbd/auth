<?php

use Illuminate\Support\Str;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

function createFreshRole()
{
    return \Fintech\Auth\Facades\Auth::role()->create([
        'name' => Str::random(20),
        'guard_name' => 'web',
    ]);
}

test('role list', function () {
    getJson('/api/auth/roles')->assertStatus(200);
});

test('role create validation', function () {
    postJson('/api/auth/roles', [
        'name' => Str::random(20),
        'guard_name' => 'web3',
    ])->assertStatus(422);
});

test('role created', function () {
    postJson('/api/auth/roles', [
        'name' => Str::random(20),
        'guard_name' => 'web',
    ])->assertStatus(201);
});

test('role not found', function () {
    createFreshRole();
    getJson('/api/auth/roles/100')->assertStatus(404);
});

test('role detail', function () {
    createFreshRole();
    getJson('/api/auth/roles/1')->assertStatus(200);
});

test('role update validation', function () {
    createFreshRole();
    putJson('/api/auth/roles/1', [
        'name' => 'abcd',
        'guard_name' => 'web3',
    ])->assertStatus(422);
});

test('role updated', function () {
    createFreshRole();
    putJson('/api/auth/roles/1', [
        'name' => Str::random(20),
    ])->assertStatus(200);
});

test('role deleted', function () {
    createFreshRole();
    deleteJson('/api/auth/roles/1')->assertStatus(200);
});

test('role restored', function () {
    $role = createFreshRole();
    $role->delete();

    postJson('/api/auth/roles/1/restore')->assertStatus(200);
});
