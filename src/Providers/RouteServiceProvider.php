<?php

namespace Fintech\Auth\Providers;

use Fintech\Auth\Http\Middlewares\IpAddressVerified;
use Fintech\Auth\Http\Middlewares\LastLoggedIn;
use Fintech\Auth\Http\Middlewares\LastLoggedOut;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $root_prefix = Config::get('auth.root_prefix', '');

        $this->routes(function () use (&$root_prefix) {
            Route::prefix("{$root_prefix}api")
                ->middleware('api')
                ->group(__DIR__ . '/../../routes/api.php');
        });

        $this->middlewareGroup('ip_verified', [IpAddressVerified::class])
            ->middlewareGroup('logged_in_at', [LastLoggedIn::class])
            ->middlewareGroup('logged_out_at', [LastLoggedOut::class]);
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->getKey() ?: $request->ip());
        });
    }
}
