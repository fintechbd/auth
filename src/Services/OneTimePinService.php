<?php

namespace Fintech\Auth\Services;

use Fintech\Auth\Enums\OTPOption;
use Fintech\Auth\Interfaces\OneTimePinRepository;
use Fintech\Auth\Notifications\OTPNotification;
use Illuminate\Support\Facades\Notification;

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

    private string $otpMethod;

    /**
     * OneTimePinService constructor.
     * @param OneTimePinRepository $oneTimePinRepository
     */
    public function __construct(OneTimePinRepository $oneTimePinRepository)
    {
        $this->oneTimePinRepository = $oneTimePinRepository;

        $this->otpMethod = config('fintech.auth.verification_method', OTPOption::Otp->value);
    }

    /**
     * @param string $authField
     * @return array
     * @throws \Exception
     */
    public function create(string $authField)
    {
        $this->delete($authField);

        $min = (int)str_pad('1', config('fintech.auth.otp_length', 4), "0");
        $max = (int)str_pad('9', config('fintech.auth.otp_length', 4), "9");

        $token = (string)mt_rand($min, $max);

        //$channel = (filter_var($authField, FILTER_VALIDATE_EMAIL) !== false) ? 'mail' : '';
        $channel = 'mail';

        $notification_data = [
            'method' => $this->otpMethod,
            'url' => null,
            'value' => $token
        ];

        if ($this->oneTimePinRepository->create($authField, $token)) {

            Notification::route($channel, $authField)->notify(new OTPNotification($notification_data));

            return ['status' => true, 'message' => __('auth::messages.verify.' . $this->otpMethod)];
        }

        return ['status' => false, 'message' => __('auth::messages.verify.failed')];
    }

    /**
     *
     * @param string $token
     * @return mixed
     * @throws \Exception
     */
    public function exists(string $token)
    {
        if ($this->otpMethod == OTPOption::Link->value) {
            try {
                $token = json_decode(base64_decode($token), true, 512, JSON_THROW_ON_ERROR);

                if (!is_array($token)) {
                    throw new \JsonException(__('auth::messages.reset.invalid_token'));
                }

                $token = array_key_first($token);

            } catch (\Exception $exception) {
                throw new \Exception($exception->getMessage());
            }
        }

        if ($verificationToken = $this->oneTimePinRepository->exists($token)) {

            $expireInSeconds = config('auth.passwords.users.expire', 5) * 60;

            $duration = now()->diffInSeconds($verificationToken->created_at);

            if ($expireInSeconds < $duration) {

                $this->delete($verificationToken->email);

                throw new \Exception(__('auth::messages.verify.expired'));
            }

            return $verificationToken;
        }

        throw new \Exception(__('auth::messages.verify.invalid'));
    }

    /**
     * @param string $authField
     */
    public function delete(string $authField)
    {
        $this->oneTimePinRepository->delete($authField);
    }
}
