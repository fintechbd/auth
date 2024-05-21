<?php

namespace Fintech\Auth\Services;

use Fintech\Auth\Interfaces\GeoIpRepository;

/**
 * Class GeoIpService
 * @package Fintech\Auth\Services
 *
 */
class GeoIpService
{
    /**
     * GeoIpService constructor.
     * @param GeoIpRepository $geoIpRepository
     */
    public function __construct(private readonly GeoIpRepository $geoIpRepository)
    {
    }

    /**
     * @param array $filters
     * @return mixed
     */
    public function lookup(array $filters = [])
    {
        return $this->geoIpRepository->list($filters);

    }

    //    public function find($id, $onlyTrashed = false)
    //    {
    //        return $this->geoIpRepository->find($id, $onlyTrashed);
    //    }
    //
    //    public function destroy($id)
    //    {
    //        return $this->geoIpRepository->delete($id);
    //    }
}
