<?php

namespace Fintech\Auth\Services;

use Fintech\Auth\Interfaces\GeoIp;

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
        return $this->driver->find($ip);
    }

}
