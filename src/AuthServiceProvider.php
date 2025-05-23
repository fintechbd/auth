<?php

namespace Fintech\Auth;

use Fintech\Auth\Commands\InstallCommand;
use Fintech\Auth\Interfaces\GeoIp;
use Fintech\Auth\Middlewares\IpAddressVerified;
use Fintech\Auth\Middlewares\LastLoggedIn;
use Fintech\Auth\Middlewares\LastLoggedOut;
use Fintech\Auth\Providers\EventServiceProvider;
use Fintech\Auth\Providers\RepositoryServiceProvider;
use Fintech\Auth\Services\Vendors\GeoIp\Local;
use Fintech\Core\Traits\Packages\RegisterPackageTrait;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    use RegisterPackageTrait;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->packageCode = 'auth';

        $this->mergeConfigFrom(
            __DIR__ . '/../config/auth.php',
            'fintech.auth'
        );

        $this->app->bind(GeoIP::class, function () {

            $default = config('fintech.auth.geoip.default', 'local');

            $config = config("fintech.auth.geoip.drivers.{$default}", ['class' => Local::class, 'path' => '']);

            return App::make($config['class'], $config);

        });

        $this->app->register(EventServiceProvider::class);
        $this->app->register(RepositoryServiceProvider::class);
    }

    /**
     * Bootstrap any package services.
     * @param Router $router
     */
    public function boot(Router $router): void
    {
        $this->injectOnConfig();

        $this->publishes([
            __DIR__ . '/../config/audit.php' => config_path('audit.php'),
            __DIR__ . '/../config/auth.php' => config_path('fintech/auth.php'),
            __DIR__ . '/../config/permission.php' => config_path('permission.php'),
        ], 'fintech-auth-config');

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'auth');

        $this->publishes([
            __DIR__ . '/../lang' => $this->app->langPath('vendor/auth'),
        ], 'fintech-auth-lang');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'auth');

        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/auth'),
        ], 'fintech-auth-views');

        $this->publishes([
            __DIR__ . '/../public' => public_path('vendor/auth'),
        ], 'fintech-auth-assets');

        $this->publishes([
            __DIR__ . '/../database/seeders/permissions.json' => database_path('seeders'),
        ], 'fintech-auth-permission-stub');

        $this->publishes([
            __DIR__ . '/../database/seeders/roles.json' => database_path('seeders'),
        ], 'fintech-auth-role-stub');

        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class
            ]);
        }

        $router->middlewareGroup('ip_verified', [IpAddressVerified::class])
            ->middlewareGroup('logged_in_at', [LastLoggedIn::class])
            ->middlewareGroup('logged_out_at', [LastLoggedOut::class]);
    }
}
