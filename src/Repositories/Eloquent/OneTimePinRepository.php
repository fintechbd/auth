<?php

namespace Fintech\Auth\Repositories\Eloquent;

use Exception;
use Fintech\Auth\Interfaces\OneTimePinRepository as InterfacesOneTimePinRepository;
use Fintech\Auth\Models\OneTimePin;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

/**
 * Class OneTimePinRepository
 */
class OneTimePinRepository implements InterfacesOneTimePinRepository
{
    private $model;

    public function __construct()
    {
        $model = app(config('fintech.auth.otp_model', OneTimePin::class));

        if (!$model instanceof Model) {
            throw new InvalidArgumentException("Eloquent repository require model class to be `Illuminate\Database\Eloquent\Model` instance.");
        }

        $this->model = $model;

        $this->model->setTable(config('auth.passwords.users.table', 'password_reset_tokens'));
    }

    /**
     * Create a new token.
     *
     * @param string $authField
     * @param string $token
     * @return null|Model
     * @throws Exception
     */
    public function create(string $authField, string $token)
    {
        try {

            $this->deleteExpired($authField);

            //determine channel
            if (filter_var($authField, FILTER_VALIDATE_EMAIL) !== false) {
                $channel = 'mail';
            } elseif (strlen($authField) >= 10) {
                $channel = 'sms';
            } else {
                $channel = 'user';
            }

            $this->model->fill(['channel' => $channel, 'email' => $authField, 'token' => $token]);

            if ($this->model->save()) {
                return $this->model;
            }
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), (int)$exception->getCode(), $exception);
        }

        return null;
    }

    /**
     * Delete expired tokens.
     *
     * @param string $authField
     * @return void
     */
    public function deleteExpired(string $authField)
    {
        $this->model->where('created_at', '<', now()->subMinutes(config('auth.passwords.users.expire')))->get()->each(function ($entry) {
            $entry->delete();
        });
    }

    /**
     * Delete a token record.
     *
     * @param string $authField
     * @return void
     */
    public function delete(string $authField)
    {
        $this->model->where('email', $authField)->get()->each(function ($entry) {
            $entry->delete();
        });
    }

    /**
     * Determine if the given user recently created a password reset token.
     *
     * @param string $token
     * @return void
     */
    private function recentlyCreatedToken(string $token)
    {
        $token = $this->exists($token);

        $expireInSeconds = config('auth.passwords.users.expire', 5) * 60;

        $duration = now()->diffInSeconds($token->created_at);

    }

    /**
     * Determine if a token record exists and is valid.
     *
     * @param string $token
     * @return mixed
     */
    public function exists(string $token)
    {
        return $this->model->where(['token' => $token])->first();
    }
}
