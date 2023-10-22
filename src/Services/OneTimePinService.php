<?php

namespace Fintech\Auth\Services;

use Fintech\Auth\Interfaces\OneTimePinRepository;

/**
 * Class PermissionService
 *
 */
class OneTimePinService
{
    /**
     * @var OneTimePinRepository
     */
    private OneTimePinRepository $oneTimePinRepository;

    /**
     * OneTimePinService constructor.
     * @param OneTimePinRepository $oneTimePinRepository
     */
    public function __construct(OneTimePinRepository $oneTimePinRepository)
    {
        $this->oneTimePinRepository = $oneTimePinRepository;
    }

    /**
     * @param $user
     * @return bool
     * @throws \Exception
     */
    public function create($user)
    {
        $authField = $user->authField();

        $this->oneTimePinRepository->delete($authField);

        $min = (int)str_pad('1', config('fintech.auth.otp_length', 4), "0");
        $max = (int)str_pad('9', config('fintech.auth.otp_length', 4), "9");

        $token = (string)mt_rand($min, $max);

        return (bool)$this->oneTimePinRepository->create($authField, $token);
    }

    public function verify($id, $onlyTrashed = false)
    {
        return $this->oneTimePinRepository->find($id, $onlyTrashed);
    }
}
