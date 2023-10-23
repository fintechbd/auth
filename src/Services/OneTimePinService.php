<?php

namespace Fintech\Auth\Services;

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

    /**
     * OneTimePinService constructor.
     * @param OneTimePinRepository $oneTimePinRepository
     */
    public function __construct(OneTimePinRepository $oneTimePinRepository)
    {
        $this->oneTimePinRepository = $oneTimePinRepository;
    }

    /**
     * @param string $authField
     * @return void
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
            'method' => 'otp',
            'url' => null,
            'value' => $token
        ];

        if ($this->oneTimePinRepository->create($authField, $token)) {
            Notification::route($channel, $authField)->notify(new OTPNotification($notification_data));
        }
    }

    /**
     *
     * @param string $token
     * @return mixed
     */
    public function exists(string $token)
    {
        return $this->oneTimePinRepository->exists($token);
    }

    /**
     * @param string $authField
     */
    public function delete(string $authField)
    {
        $this->oneTimePinRepository->delete($authField);
    }
}
