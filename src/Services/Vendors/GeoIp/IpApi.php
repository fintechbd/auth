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

    /**
     * @throws \JsonException
     */
    public function find(string $ip): mixed
    {
        $response = Http::baseUrl("https://api.ipapi.com/api/")
            ->contentType('application/json')
            ->acceptJson()
            ->get($ip, [
                'access_key' => $this->token,
                'output' => 'json',
                'language' => 'en'
            ]);

        if (!$response->json()) {
            throw new \JsonException("Invalid IP API Response.");
        }

        $response = $response->json();

        if (isset($response['success']) && !$response['success']) {
            throw new \JsonException("IP API Error: " . $response->json('error.info'));
        }

        return $response;
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
