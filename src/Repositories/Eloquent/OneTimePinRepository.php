<?php

namespace Fintech\Auth\Repositories\Eloquent;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Fintech\Auth\Interfaces\OneTimePinRepository as InterfacesOneTimePinRepository;
use InvalidArgumentException;

/**
 * Class OneTimePinRepository
 */
class OneTimePinRepository implements InterfacesOneTimePinRepository
{
    /**
     * @var \Illuminate\Contracts\Foundation\Application|Model|\Illuminate\Foundation\Application
     */
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
     * @param string $authField
     * @return null|string
     * @throws Exception
     */
    public function create(string $authField)
    {
        try {

            $this->deleteExpired($authField);

            $min = (int)str_pad('1', config('fintech.auth.otp_length', 4), "0");
            $max = (int)str_pad('9', config('fintech.auth.otp_length', 4), "9");

            $token = mt_rand($min, $max);

            $this->model->fill(['email' => $authField, 'token' => $token]);

            if ($this->model->save()) {
                return $token;
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
     * @return bool
     */
    public function exists(string $authField, string $token)
    {
        return $this->model->where(['email' => $authField, 'token' => $token])->first();
    }

    /**
     * Determine if the given user recently created a password reset token.
     *
     * @param string $authField
     * @param string $token
     * @return void
     */
    private function recentlyCreatedToken(string $authField, string $token)
    {
        $token = $this->exists($authField, $token);

        $expireInSeconds = config('auth.passwords.users.expire', 5) * 60;

        $duration = now()->diffInSeconds($token->created_at);

    }

    /**
     * Delete a token record.
     *
     * @param CanResetPasswordContract $user
     * @return void
     */
    public function delete(CanResetPasswordContract $user){

    }

    /**
     * Delete expired tokens.
     *
     * @param string $authField
     * @return void
     */
    public function deleteExpired(string $authField) {
        $this->model->where('email', $authField)->get()->each(function ($entry) {
           $entry->delete();
        });
    }
}