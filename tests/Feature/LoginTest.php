<?php

use function Pest\Laravel\postJson;

test('login failed', function () {
    postJson('/api/auth/permissions', [
        'login_id' => '01600000001',
        'password' => '12345678',
    ])->assertStatus(422);
});
