<?php

namespace Fintech\Auth\Providers;

use Fintech\Auth\Interfaces\GeoIp;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use InvalidArgumentException;

class RepositoryServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        foreach (Config::get('fintech.auth.repositories', []) as $interface => $binding) {
            $this->app->bind($interface, function ($app) use ($binding) {
                return $app->make($binding);
            });
        }

        $this->app->singleton(GeoIp::class, function ($app) {

            if ($current = config('fintech.auth.geoip.default')) {

                if (!config("fintech.auth.geoip.drivers.{$current}")) {
                    throw new InvalidArgumentException("No driver configuration found named `{$current}`.");
                }

                $config = config("fintech.auth.geoip.drivers.{$current}");

                $class = $config['class'];

                unset($config['class']);

                return new $class($config);

            } else {
                throw new InvalidArgumentException("No driver is assigned for GeoIP Service.");
            }
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array<int, string>
     */
    public function provides(): array
    {
        return [GeoIp::class, ...array_keys(Config::get('fintech.auth.repositories', []))];
    }
}
