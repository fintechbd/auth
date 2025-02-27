<?php

namespace Fintech\Auth\Services;

use Exception;
use Fintech\Auth\Events\OtpRequested;
use Fintech\Auth\Events\OtpVerified;
use Fintech\Auth\Interfaces\OneTimePinRepository;
use Fintech\Auth\Notifications\OTPNotification;
use Fintech\Core\Enums\Auth\OTPOption;
use Illuminate\Support\Facades\Notification;
use JsonException;

/**
 * Class PermissionService
 *
 */
class OneTimePinService
{
    use \Fintech\Core\Traits\HasFindWhereSearch;

    private string $otpMethod;

    /**
     * OneTimePinService constructor.
     * @param OneTimePinRepository $oneTimePinRepository
     */
    public function __construct(private readonly OneTimePinRepository $oneTimePinRepository)
    {
        $this->otpMethod = config('fintech.auth.verification_method', OTPOption::Otp->value);
    }

    /**
     * @param string $authField
     * @return array
     * @throws Exception
     */
    public function create(string $authField): array
    {
        $this->delete($authField);

        $min = (int)str_pad('1', config('fintech.auth.otp_length', 4), "0");
        $max = (int)str_pad('9', config('fintech.auth.otp_length', 4), "9");

        $token = (string)mt_rand($min, $max);

        $notification = [
            'method' => $this->otpMethod,
            'url' => null,
            'value' => $token
        ];

        if ($otp = $this->oneTimePinRepository->create($authField, $token)) {

            event(new OtpRequested($notification));

            Notification::route(
                (filter_var($authField, FILTER_VALIDATE_EMAIL) !== false) ? 'mail' : 'sms',
                $authField
            )
                ->notify(new OTPNotification($notification));

            $response = [
                'status' => true,
                'message' => __('auth::messages.verify.' . $this->otpMethod, [
                    'channel' => (filter_var($authField, FILTER_VALIDATE_EMAIL) !== false) ? 'Mail' : 'SMS']),
            ];

            if (!app()->isProduction()) {
                $response['otp'] = $otp->token ?? null;
            }

            return $response;
        }

        return [
            'status' => false,
            'message' => __('auth::messages.verify.failed')
        ];
    }

    /**
     * @param string $authField
     */
    public function delete(string $authField): void
    {
        $this->oneTimePinRepository->delete($authField);
    }

    /**
     *
     * @param string $token
     * @return mixed
     * @throws Exception
     */
    public function exists(string $token)
    {
        if ($this->otpMethod == OTPOption::Link->value) {
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

        if ($verificationToken = $this->oneTimePinRepository->exists($token)) {

            $expireInSeconds = config('auth.passwords.users.expire', 5) * 60;

            $duration = now()->diffInSeconds($verificationToken->created_at);

            if ($expireInSeconds < $duration) {

                $this->delete($verificationToken->email);

                throw new Exception(__('auth::messages.verify.expired'));
            }

            event(new OtpVerified($verificationToken));

            return $verificationToken;
        }

        throw new Exception(__('auth::messages.verify.invalid'));
    }
}
