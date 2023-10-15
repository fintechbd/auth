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
     * @return void
     * @throws \Exception
     */
    public function create($user)
    {
        $authField = $user->authField();

        $this->oneTimePinRepository->deleteExpired($authField);

        $min = (int)str_pad('1', config('fintech.auth.otp_length', 4), "0");
        $max = (int)str_pad('9', config('fintech.auth.otp_length', 4), "9");

        $token = (string)mt_rand($min, $max);

        if($this->oneTimePinRepository->create($authField, $token)) {
            $user->notify();
        }
    }

    //    public function find($id, $onlyTrashed = false)
    //    {
    //        return $this->oneTimePinRepository->find($id, $onlyTrashed);
    //    }
    //
    //    public function update($id, array $inputs = [])
    //    {
    //        return $this->oneTimePinRepository->update($id, $inputs);
    //    }
    //
    //    public function destroy($id)
    //    {
    //        return $this->oneTimePinRepository->delete($id);
    //    }
    //
    //    public function restore($id)
    //    {
    //        return $this->oneTimePinRepository->restore($id);
    //    }

    private function getUser(string $authField)
    {
    }
}
