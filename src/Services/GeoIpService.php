<?php

namespace Fintech\Auth\Services;

use Fintech\Auth\Interfaces\GeoIp;
use Illuminate\Support\Facades\Cache;

/**
 * Class GeoIpService
 * @package Fintech\Auth\Services
 *
 */
class GeoIpService
{
    public function __construct(private readonly GeoIp $driver)
    {

    }

    /**
     * @param string $ip
     * @return mixed
     */
    public function find(string $ip): mixed
    {
        return Cache::remember($ip . '-info', HOUR, function () use ($ip) {
            return $this->driver->find($ip);
        });
    }

}
