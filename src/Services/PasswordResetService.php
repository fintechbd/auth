<?php

namespace Fintech\Auth\Services;

use Fintech\Auth\Facades\Auth;
use Fintech\Auth\Interfaces\OneTimePinRepository;
use Fintech\Auth\Notifications\SendPasswordResetNotification;
use Illuminate\Support\Str;

/**
 * Class PermissionService
 *
 */
class PasswordResetService
{

    /**
     * @var mixed|string
     */
    private string $passwordField;
    /**
     * @var OneTimePinRepository
     */
    private OneTimePinRepository $oneTimePinRepository;
    /**
     * @var string|null
     */
    private string  $resetMethod;

    /**
     * OneTimePinService constructor.
     * @param OneTimePinRepository $oneTimePinRepository
     */
    public function __construct(OneTimePinRepository $oneTimePinRepository)
    {
        $this->oneTimePinRepository = $oneTimePinRepository;

        $this->passwordField = config('fintech.auth.password_field', 'password');

        $this->resetMethod = config('fintech.auth.password_reset_method', 'reset_link');
    }

    /**
     * @param $user
     * @return bool
     */
    public function notify($user)
    {
        $notification_data = [
            'method' => $this->resetMethod,
            'data' => []
        ];

        switch ($this->resetMethod) {
            case 'temporary_password' :
                $notification_data['data'] = $this->viaTemporaryPassword($user);
                break;

            case 'otp' :
                $notification_data['data'] = $this->viaOneTimePin($user);
                break;

            default :
                $notification_data['data'] = $this->viaResetLink($user);
        }

        $user->notify(new SendPasswordResetNotification($notification_data));

        return true;
    }

    private function viaTemporaryPassword($user)
    {
        $password = Str::random(config('fintech.auth.temporary_password_length', 8));

        if (Auth::user()->update($user->getKey(), [$this->passwordField => $password])) {
            return;
        }
    }

    private function viaResetLink($user)
    {
        $password = Str::random(config('fintech.auth.temporary_password_length', 8));

        if (Auth::user()->update($user->getKey(), [$this->passwordField => $password])) {
            return;
        }
    }

    private function viaOneTimePin($user)
    {
        $authField = $user->authField();

        $this->oneTimePinRepository->deleteExpired($authField);

        $min = (int)str_pad('1', config('fintech.auth.otp_length', 4), "0");
        $max = (int)str_pad('9', config('fintech.auth.otp_length', 4), "9");

        $token = (string)mt_rand($min, $max);

        if ($otp = $this->oneTimePinRepository->create($authField, $token)) {
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
}
