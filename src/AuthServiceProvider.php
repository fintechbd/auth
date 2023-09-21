<?php

namespace Fintech\Auth;

use Illuminate\Support\ServiceProvider;
use Fintech\Auth\Commands\InstallCommand;
use Fintech\Auth\Commands\AuthCommand;

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
            __DIR__.'/../config/auth.php', 'auth'
        );

        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/auth.php' => config_path('auth.php'),
        ]);

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->loadTranslationsFrom(__DIR__.'/../lang', 'auth');

        $this->publishes([
            __DIR__.'/../lang' => $this->app->langPath('vendor/auth'),
        ]);

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'auth');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/auth'),
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
                AuthCommand::class,
            ]);
        }
    }
}
