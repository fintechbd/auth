<?php

namespace Fintech\Auth\Commands;

use Fintech\Auth\Facades\Auth;
use Fintech\Auth\Seeders\PermissionSeeder;
use Fintech\Core\Enums\Auth\SystemRole;
use Fintech\Core\Traits\HasCoreSettingTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class InstallCommand extends Command
{
    use HasCoreSettingTrait;

    public $signature = 'auth:install';
    public $description = 'Configure the system for the `fintech/auth` module';
    private string $module = 'Auth';
    private array $settings = [
        [
            'package' => 'auth',
            'label' => 'User Authentication Field',
            'description' => 'Unique field that can be used to authenticated a end user to system',
            'key' => 'auth_field',
            'type' => 'string',
            'value' => 'login_id'
        ],
        [
            'package' => 'auth',
            'label' => 'OTP Key Length',
            'description' => 'Number of digits that otp key will have',
            'key' => 'otp_length',
            'type' => 'integer',
            'value' => '6'
        ],
        [
            'package' => 'auth',
            'label' => 'Password',
            'description' => 'Which field in user table will maintain the password field value',
            'key' => 'password_field',
            'type' => 'string',
            'value' => 'password'
        ],
        [
            'package' => 'auth',
            'label' => 'Wrong Password Warning Limit',
            'description' => 'Number to times a user can attempt with wrong password before account become in active',
            'key' => 'password_threshold',
            'type' => 'integer',
            'value' => '10'
        ],
        [
            'package' => 'auth',
            'label' => 'Wrong Pin Warning Limit',
            'description' => 'Number to times a user can attempt with wrong pin on transaction before account become in active',
            'key' => 'pin_threshold',
            'type' => 'integer',
            'value' => '3'
        ],
        [
            'package' => 'auth',
            'label' => 'Send Account De-activated Notification',
            'description' => 'When account is freeze for suspicious activity send notification to email or mobile',
            'key' => 'threshold_notification',
            'type' => 'boolean',
            'value' => 'false'
        ],
        [
            'package' => 'auth',
            'label' => 'Frontend Register Default Role',
            'description' => 'Set the Default Role(s) for the Registration Customer',
            'key' => 'customer_roles',
            'type' => 'array',
            'value' => '[7]'
        ],
        [
            'package' => 'auth',
            'label' => 'How User will reset their password',
            'description' => 'When a user forgot password. he have follow this configured option to reset password.',
            'key' => 'password_reset_method',
            'type' => 'string',
            'value' => 'temporary_password'
        ],
        [
            'package' => 'auth',
            'label' => 'Length of Temporary Password',
            'description' => 'Number of Alpha-numeric characters in Temporary Password when generated',
            'key' => 'temporary_password_length',
            'type' => 'integer',
            'value' => '8'
        ]
    ];

    public function handle(): int
    {
        $this->task("Module Installation", function () {
            $this->addSettings();

            $this->addPermissions();

            $this->addRoles();

        }, "COMPETED");

        return self::SUCCESS;
    }

    private function addPermissions(): void
    {
        $this->task("Creating system permissions", function () {
            Artisan::call('vendor:publish --tag=fintech-permissions --quiet');
            Artisan::call('db:seed --class=' . addslashes(PermissionSeeder::class) . ' --quiet');
        });
    }

    private function addRoles(): void
    {
        $roles = [
            [
                'name' => SystemRole::SuperAdmin->value,
                'guard_name' => 'web',
                'permissions' => Auth::permission()->list()->pluck('id')->toArray()
            ],
            [
                'name' => SystemRole::MasterUser->value,
                'guard_name' => 'web',
                'permissions' => []
            ],
        ];

        $this->task("Creating system roles", function () use ($roles) {
            foreach ($roles as $role) {
                Auth::role()->create($role);
            }
        });
    }
}
