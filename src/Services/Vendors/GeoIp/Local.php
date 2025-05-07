<?php

namespace Fintech\Auth\Services\Vendors\GeoIp;

use Fintech\Auth\Interfaces\GeoIp;

class Local implements GeoIp
{
    /**
     * geoip driver contractor
     *
     * @param array $config
     */
    public function __construct(public array $config = [])
    {
    }

    /**
     */
    public function find(string $ip): mixed
    {
        return [
            "ip" => $ip,
            "type" => "ipv4",
            "continent_code" => "AS",
            "continent_name" => "Asia",
            "country_code" => "BD",
            "country_name" => "Bangladesh",
            "region_code" => "C",
            "region_name" => "Dhaka",
            "city" => "Bhātāra",
            "zip" => "1000",
            "latitude" => 23.810300827026,
            "longitude" => 90.412498474121,
            "msa" => null,
            "dma" => null,
            "radius" => null,
            "ip_routing_type" => "mobile gateway",
            "connection_type" => "mobile wireless",
            "location" => [
                "geoname_id" => 1209106,
                "capital" => "Dhaka",
                "languages" => [
                    [
                        "code" => "bn",
                        "name" => "Bengali",
                        "native" => "বাংলা"
                    ]
                ],
                "country_flag" => "https://assets.ipstack.com/flags/bd.svg",
                "country_flag_emoji" => "🇧🇩",
                "country_flag_emoji_unicode" => "U+1F1E7 U+1F1E9",
                "calling_code" => "880",
                "is_eu" => false
            ],
            "time_zone" => [
                "id" => "Asia/Dhaka",
                "current_time" => "2025-04-16T12:32:29+06:00",
                "gmt_offset" => 21600,
                "code" => "+06",
                "is_daylight_saving" => false
            ],
            "currency" => [
                "code" => "BDT",
                "name" => "Bangladeshi Taka",
                "plural" => "Bangladeshi takas",
                "symbol" => "Tk",
                "symbol_native" => "৳"
            ],
            "connection" => [
                "asn" => 24389,
                "isp" => "Grameenphone Ltd.",
                "sld" => null,
                "tld" => null,
                "carrier" => "grameenphone ltd.",
                "home" => true,
                "organization_type" => "Internet Service Provider",
                "isic_code" => "J6120",
                "naics_code" => "517312"
            ]
        ];

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
