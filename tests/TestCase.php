<?php

namespace Fintech\Auth\Tests;

use Fintech\Auth\AuthServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            AuthServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'mysql');

        /*
        $migration = include __DIR__.'/../database/migrations/create_auth_table.php.stub';
        $migration->up();
        */
    }
}
