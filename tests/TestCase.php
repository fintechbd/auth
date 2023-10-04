<?php

namespace Fintech\Auth\Tests;

use Fintech\Auth\AuthServiceProvider;
use Illuminate\Foundation\Testing\DatabaseMigrations;
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
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
        config()->set('audit.drivers.database.connection', 'testing');


        $migrations = [
            include __DIR__ . '/../../../database/migrations/2014_10_12_000000_create_users_table.php'
        ];

        foreach ($migrations as $migration) {
            $migration->up();
        }
    }
}
