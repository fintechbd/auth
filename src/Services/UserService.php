<?php

namespace Fintech\Auth\Services;

use Fintech\Auth\Interfaces\UserRepository;

/**
 * Class UserService
 *
 * @property-read UserRepository $userRepository
 */
class UserService
{
    /**
     * UserService constructor.
     */
    public function __construct(private UserRepository $userRepository)
    {
    }

    /**
     * @return mixed
     */
    public function list(array $filters = [])
    {
        $countryList = $this->userRepository->list($filters);

        //Do Business Stuff

        return $countryList;

    }

    public function create(array $inputs = [])
    {
        return $this->userRepository->create($inputs);
    }

    public function read($id)
    {
        return $this->userRepository->read($id);
    }

    public function update($id, array $inputs = [])
    {
        return $this->userRepository->update($id, $inputs);
    }

    public function destroy($id)
    {
        return $this->userRepository->delete($id);
    }

    public function restore($id)
    {
        return $this->userRepository->restore($id);
    }
}
