<?php

namespace Fintech\Auth;

use Fintech\Auth\Interfaces\PermissionRepository;
use Fintech\Auth\Interfaces\RoleRepository;
use Fintech\Auth\Interfaces\TeamRepository;
use Fintech\Auth\Interfaces\UserProfileRepository;
use Fintech\Auth\Interfaces\UserRepository;
use Fintech\Auth\Repositories\Eloquent\PermissionRepository as EloquentPermissionRepository;
use Fintech\Auth\Repositories\Eloquent\RoleRepository as EloquentRoleRepository;
use Fintech\Auth\Repositories\Eloquent\TeamRepository as EloquentTeamRepository;
use Fintech\Auth\Repositories\Eloquent\UserProfileRepository as EloquentUserProfileRepository;
use Fintech\Auth\Repositories\Eloquent\UserRepository as EloquentUserRepository;
use Fintech\Auth\Repositories\Mongodb\PermissionRepository as MongodbPermissionRepository;
use Fintech\Auth\Repositories\Mongodb\RoleRepository as MongodbRoleRepository;
use Fintech\Auth\Repositories\Mongodb\TeamRepository as MongodbTeamRepository;
use Fintech\Auth\Repositories\Mongodb\UserProfileRepository as MongodbUserProfileRepository;
use Fintech\Auth\Repositories\Mongodb\UserRepository as MongodbUserRepository;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public array $repositories = [
        PermissionRepository::class => [
            'default' => EloquentPermissionRepository::class,
            'mongodb' => MongodbPermissionRepository::class
        ],
        RoleRepository::class => [
            'default' => EloquentRoleRepository::class,
            'mongodb' => MongodbRoleRepository::class
        ],
        TeamRepository::class => [
            'default' => EloquentTeamRepository::class,
            'mongodb' => MongodbTeamRepository::class
        ],
        UserProfileRepository::class => [
            'default' => EloquentUserProfileRepository::class,
            'mongodb' => MongodbUserProfileRepository::class
        ],
        UserRepository::class => [
            'default' => EloquentUserRepository::class,
            'mongodb' => MongodbUserRepository::class
        ],
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        foreach ($this->repositories as $interface => $bindings) {
            $this->app->bind($interface, function () use ($bindings) {
                return match(config('database.default')){
                'mongodb' => new $bindings['mongodb'](),
                default => new $bindings['default'](),
            };
        }, true);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array<int, string>
     */
    public function provides(): array
    {
        return array_keys($this->repositories);
    }
}
