<?php

namespace Fintech\Auth;

use Fintech\Auth\Commands\AuthCommand;
use Fintech\Auth\Commands\InstallCommand;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/auth.php',
            'fintech.auth'
        );
    }

    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/audit.php' => config_path('audit.php'),
            __DIR__ . '/../config/auth.php' => config_path('fintech/auth.php'),
            __DIR__ . '/../config/permission.php' => config_path('permission.php'),
        ]);

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'auth');

        $this->publishes([
            __DIR__ . '/../lang' => $this->app->langPath('vendor/auth'),
        ]);

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'auth');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/auth'),
        ]);

        $this->publishes([
            __DIR__ . '/../public' => public_path('vendor/auth'),
        ], 'fintech-auth-assets');

        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
                AuthCommand::class,
            ]);
        }
    }
}
