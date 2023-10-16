<?php

namespace Fintech\Auth\Services;

use Fintech\Auth\Facades\Auth;
use Fintech\Auth\Interfaces\OneTimePinRepository;
use Fintech\Auth\Notifications\SendPasswordResetNotification;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
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
     * @return array
     */
    public function notify($user)
    {
        try {

            switch ($this->resetMethod) {
                case 'temporary_password' :
                    $notification_data = $this->viaTemporaryPassword($user);
                    break;

                case 'otp' :
                    $notification_data = $this->viaOneTimePin($user);
                    break;

                default :
                    $notification_data = $this->viaResetLink($user);
            }

            $notification_data['method'] = $this->resetMethod;

            if ($notification_data['status']) {

                $user->notify(new SendPasswordResetNotification($notification_data));

                return ['message' => $notification_data['message'], 'status' => true];
            }

            return ['message' => $notification_data['message'], 'status' => false];

        } catch (\Exception $exception) {

            return ['message' => $exception->getMessage(), 'status' => false];
        }
    }

    private function viaTemporaryPassword($user): array
    {
        $password = Str::random(config('fintech.auth.temporary_password_length', 8));

        if (App::environment('local')) {
            Log::info("User ID: {$user->getKey()}, Temporary Password: {$password}");
        }

        if (Auth::user()->update($user->getKey(), [$this->passwordField => $password])) {
            return [
                'message' => __('auth::messages.reset.temporary_password'),
                'value' => $password,
                'url' => url(config('fintech.auth.frontend_login_url')),
                'status' => true
            ];
        }

        return [
            'message' => __('auth::messages.reset.notification_failed'),
            'value' => null,
            'url' => url(config('fintech.auth.frontend_login_url')),
            'status' => false
        ];
    }

    private function viaResetLink($user)
    {
        $authField = $user->authField();

        $this->oneTimePinRepository->deleteExpired($authField);

        $token = Str::random(40);

        $token_url = url(config('fintech.auth.frontend_reset_url')) . '?token=' . base64_encode(json_encode([$token => $authField]));

        if (App::environment('local')) {
            Log::info("User ID: {$user->getKey()}, Password Link: {$token_url}");
        }

        if ($this->oneTimePinRepository->create($authField, $token)) {

            return [
                'message' => __('auth::messages.reset.reset_link'),
                'value' => null,
                'url' => $token_url,
                'status' => true
            ];
        }

        return [
            'message' => __('auth::messages.reset.notification_failed'),
            'value' => null,
            'url' => url(config('fintech.auth.frontend_reset_url')),
            'status' => false
        ];
    }

    private function viaOneTimePin($user)
    {
        $authField = $user->authField();

        $this->oneTimePinRepository->deleteExpired($authField);

        $min = (int)str_pad('1', config('fintech.auth.otp_length', 4), "0");
        $max = (int)str_pad('9', config('fintech.auth.otp_length', 4), "9");

        $token = (string)mt_rand($min, $max);

        if (App::environment('local')) {
            Log::info("User ID: {$user->getKey()}, OTP: {$token}");
        }

        if ($this->oneTimePinRepository->create($authField, $token)) {

            return [
                'message' => __('auth::messages.reset.temporary_password'),
                'value' => $token,
                'status' => true,
                'url' => null
            ];
        }

        return [
            'message' => __('auth::messages.reset.notification_failed'),
            'value' => null,
            'status' => false,
            'url' => null
        ];
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
