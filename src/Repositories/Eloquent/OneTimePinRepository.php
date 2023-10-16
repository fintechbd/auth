<?php

namespace Fintech\Auth\Repositories\Eloquent;

use Exception;
use Fintech\Auth\Interfaces\OneTimePinRepository as InterfacesOneTimePinRepository;
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
        $model = app(config('fintech.auth.otp_model', \Fintech\Auth\Models\OneTimePin::class));

        if (!$model instanceof Model) {
            throw new InvalidArgumentException("Eloquent repository require model class to be `Illuminate\Database\Eloquent\Model` instance.");
        }

        $this->model = $model;

        $this->model->setTable(config('auth.passwords.users.table', 'password_reset_tokens'));
    }

    /**
     * Create a new token.
     *
     * @param array $attributes ']
     * @return null|Model
     * @throws Exception
     */
    public function create(string $authField, string $token)
    {
        try {

            $this->deleteExpired($authField);

            $this->model->fill(['email' => $authField, 'token' => $token]);

            if ($this->model->save()) {
                return $this->model;
            }
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode(), $exception);
        }

        return null;
    }

    /**
     * Determine if a token record exists and is valid.
     *
     * @param string $authField
     * @param string $token
     */
    public function exists(string $token)
    {
        return $this->model->where(['token' => $token])->first();
    }

    /**
     * Determine if the given user recently created a password reset token.
     *
     * @param string $authField
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
}
