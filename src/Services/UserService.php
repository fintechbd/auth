<?php

namespace Fintech\Auth\Services;

use Fintech\Auth\Interfaces\UserRepository;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserService
 *
 * @property-read UserRepository $userRepository
 */
class UserService
{
    public $userRepository;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
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
        $inputs['password'] = Hash::make($inputs['password']);
        $inputs['pin'] = Hash::make($inputs['pin']);

        return $this->userRepository->create($inputs);
    }

    public function read($id)
    {
        return $this->userRepository->read($id);
    }

    public function update($id, array $inputs = [])
    {
        if ($inputs['password']) {
            $inputs['password'] = Hash::make($inputs['password']);
        }
        if ($inputs['pin']) {
            $inputs['pin'] = Hash::make($inputs['pin']);
        }

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
