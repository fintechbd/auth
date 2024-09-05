<?php

namespace Fintech\Auth\Services\Vendors\GeoIp;

use Fintech\Auth\Interfaces\GeoIp;
use Illuminate\Support\Facades\Http;
use InvalidArgumentException;

class IpApi implements GeoIp
{
    private ?string $token;

    /**
     * geoip driver contractor
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        if (!$config['token']) {
            throw new InvalidArgumentException("IP API Access Key is missing.");
        }

        $this->token = $config['token'];
    }

    public function find(string $ip): mixed
    {

        $response = Http::baseUrl("https://api.ipapi.com/api/")->get($ip, [
            'access_key' => $this->token,
            'output' => 'json',
            'language' => 'en'
        ]);

        return $response->json();
    }

    /**
     * find and delete an entry from records
     * @param int|string $id
     */
    public function delete(int|string $id)
    {
        // TODO: Implement delete() method.
    }
}
