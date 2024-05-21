<?php

namespace Fintech\Auth\Services\Vendors\GeoIp;

use Fintech\Auth\Interfaces\GeoIp;

class Cloudflare implements GeoIp
{
    /**
     * return a response of driver location information
     * from ip address
     *
     * @param string $ip
     * @return mixed
     */
    public function find(string $ip): mixed
    {
        // TODO: Implement find() method.
    }

    /**
     * find and delete a entry from records
     * @param int|string $id
     */
    public function delete(int|string $id)
    {
        // TODO: Implement delete() method.
    }
}
