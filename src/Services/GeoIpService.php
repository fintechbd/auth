<?php

namespace Fintech\Auth\Services;

use Fintech\Auth\Interfaces\GeoIp;
use Illuminate\Contracts\Container\BindingResolutionException;

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
    public function lookup(string $ip)
    {
        return $this->driver->lookup($ip);
    }

}
