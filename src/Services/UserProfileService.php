<?php

namespace Fintech\Auth\Services;


use Fintech\Auth\Interfaces\UserProfileRepository;

/**
 * Class UserProfileService
 * @package Fintech\Auth\Services
 *
 * @property-read UserProfileRepository $userProfileRepository
 */
class UserProfileService
{
    /**
     * UserProfileService constructor.
     * @param UserProfileRepository $userProfileRepository
     */
    public function __construct(private UserProfileRepository $userProfileRepository) { }

    /**
     * @param array $filters
     * @return mixed
     */
    public function list(array $filters = [])
    {
        $countryList = $this->userProfileRepository->list($filters);

        //Do Business Stuff

        return $countryList;

    }

    public function create(array $inputs = [])
    {
        return $this->userProfileRepository->create($inputs);
    }

    public function read($id)
    {
        return $this->userProfileRepository->read($id);
    }

    public function update($id, array $inputs = [])
    {
        return $this->userProfileRepository->update($id, $inputs);
    }

    public function destroy($id)
    {
        return $this->userProfileRepository->delete($id);
    }

    public function restore($id)
    {
        return $this->userProfileRepository->restore($id);
    }
}
