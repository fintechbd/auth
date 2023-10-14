<?php

namespace Fintech\Auth\Tests;

use Fintech\Auth\AuthServiceProvider;
use Fintech\MetaData\MetaDataServiceProvider;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Sanctum\SanctumServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\Permission\PermissionServiceProvider;

class TestCase extends Orchestra
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            PermissionServiceProvider::class,
            AuthServiceProvider::class,
            MetaDataServiceProvider::class,
            SanctumServiceProvider::class
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('app.env', 'testing');
        config()->set('database.default', 'testing');


        $migrations = [
//            include __DIR__ . '/../database/migrations/2014_10_12_000000_create_users_table.php',
//            include __DIR__ . '/../database/migrations/2023_09_25_201631_create_profiles_table.php',
//            include __DIR__ . '/../database/migrations/2023_09_28_224955_create_permission_tables.php',
//            include __DIR__ . '/../database/migrations/2023_09_28_230630_create_teams_table.php',
//            include __DIR__ . '/../database/migrations/2019_12_14_000001_create_personal_access_tokens_table.php'
        ];

        foreach ($migrations as $migration) {
            $migration->up();
        }
    }
}
