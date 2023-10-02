<?php

namespace Fintech\Auth\Services;

use Fintech\Auth\Interfaces\ProfileRepository;

/**
 * Class UserProfileService
 */
class ProfileService
{
    private $profileRepository;

    /**
     * UserProfileService constructor.
     */
    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    /**
     * @return mixed
     */
    public function list(array $filters = [])
    {
        $countryList = $this->profileRepository->list($filters);

        //Do Business Stuff

        return $countryList;

    }

    public function create(array $inputs = [])
    {
        return $this->profileRepository->create($inputs);
    }

    public function find($id)
    {
        return $this->profileRepository->find($id);
    }

    public function update($id, array $inputs = [])
    {
        return $this->profileRepository->update($id, $inputs);
    }

    public function destroy($id)
    {
        return $this->profileRepository->delete($id);
    }

    public function restore($id)
    {
        return $this->profileRepository->restore($id);
    }
}
