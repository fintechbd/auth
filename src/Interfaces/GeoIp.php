<?php

namespace Fintech\Auth\Interfaces;

/**
 * Interface GeoIp
 * @package Fintech\Auth\Interfaces
 */
interface GeoIp
{
    /**
     * geoip driver contractor
     *
     * @param array $config
     */
    public function __construct(array $config = []);

    /**
     * return a response of driver location information
     * from ip address
     *
     * @param string $ip
     * @return mixed
     */
    public function find(string $ip): mixed;

    /**
     * find and delete a entry from records
     * @param int|string $id
     */
    public function delete(int|string $id);

}
