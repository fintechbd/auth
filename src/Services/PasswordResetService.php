<?php

namespace Fintech\Auth\Services;

use Exception;
use Fintech\Auth\Interfaces\OneTimePinRepository;
use Fintech\Auth\Interfaces\UserRepository;
use Fintech\Auth\Notifications\PasswordResetNotification;
use Fintech\Core\Abstracts\BaseModel;
use Fintech\Core\Enums\Auth\PasswordResetOption;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use JsonException;

/**
 * Class PermissionService
 *
 */
class PasswordResetService
{
    use \Fintech\Core\Traits\HasFindWhereSearch;

    /**
     * @var mixed|string
     */
    private string $passwordField;

    /**
     * @var string|null
     */
    private ?string $resetMethod;


    /**
     * OneTimePinService constructor.
     * @param OneTimePinRepository $oneTimePinRepository
     * @param UserRepository $userRepository
     */
    public function __construct(
        private readonly OneTimePinRepository $oneTimePinRepository,
        private readonly UserRepository       $userRepository
    ) {
        $this->passwordField = config('fintech.auth.password_field', 'password');

        $this->resetMethod = config('fintech.auth.password_reset_method', PasswordResetOption::ResetLink->value);
    }

    /**
     * @param $user
     * @return array
     */
    public function notifyUser($user)
    {
        try {

            $notification_data = match ($this->resetMethod) {
                PasswordResetOption::TemporaryPassword->value => $this->viaTemporaryPassword($user),
                PasswordResetOption::Otp->value => $this->viaOneTimePin($user),
                default => $this->viaResetLink($user),
            };

            $notification_data['method'] = $this->resetMethod;

            if ($notification_data['status']) {

                $user->notify(new PasswordResetNotification($notification_data));

                return ['message' => $notification_data['message'], 'status' => true];
            }

            return ['message' => $notification_data['message'], 'status' => false];

        } catch (Exception $exception) {

            return ['message' => $exception->getMessage(), 'status' => false];
        }
    }

    /**
     * @param $user
     * @return array
     */
    private function viaTemporaryPassword($user): array
    {
        $password = Str::random(config('fintech.auth.temporary_password_length', 8));

        if (App::environment('local')) {
            Log::info("User ID: {$user->getKey()}, Temporary Password: {$password}");
        }

        if ($this->userRepository->update(
            $user->getKey(),
            [$this->passwordField => Hash::make($password)]
        )) {
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

    /**
     * @param $user
     * @return array
     * @throws Exception
     */
    private function viaOneTimePin($user)
    {
        $authField = $user->authField();

        $this->oneTimePinRepository->delete($authField);

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

    /**
     * @param $user
     * @return array
     * @throws Exception
     */
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

    /**
     * @param string $token
     * @return BaseModel
     * @throws Exception
     */
    public function verifyToken(string $token)
    {

        if ($this->resetMethod == 'reset_link') {
            try {
                $token = json_decode(base64_decode($token), true, 512, JSON_THROW_ON_ERROR);

                if (!is_array($token)) {
                    throw new JsonException(__('auth::messages.reset.invalid_token'));
                }

                $token = array_key_first($token);

            } catch (Exception $exception) {
                throw new Exception($exception->getMessage());
            }
        }


        if ($passwordResetToken = $this->oneTimePinRepository->exists($token)) {

            $expireInSeconds = config('auth.passwords.users.expire', 5) * 60;

            $duration = now()->diffInSeconds($passwordResetToken->created_at);

            if ($expireInSeconds < $duration) {

                $this->oneTimePinRepository->delete($passwordResetToken->email);

                throw new Exception(__('auth::messages.reset.expired_token'));
            }

            return $passwordResetToken;
        }

        throw new Exception(__('auth::messages.reset.invalid_token'));
    }
}
