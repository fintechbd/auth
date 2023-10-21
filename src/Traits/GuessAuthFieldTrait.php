<?php


namespace Fintech\Auth\Traits;


trait GuessAuthFieldTrait
{
    /**
     * Return user model auth field from input format
     *
     * @param $request
     * @return array
     */
    private function getAuthFieldFromInput($request)
    {
        $authFieldValue = $request->input(config('fintech.auth.auth_field', 'login_id'));

        if (filter_var($authFieldValue, FILTER_VALIDATE_EMAIL)) {
            return ['email' => $authFieldValue];
        } elseif (preg_match('/^(\d{7,15})$/', $authFieldValue) > 0) {
            return ['mobile' => $authFieldValue];
        } else {
            return [config('fintech.auth.auth_field', 'login_id') => $authFieldValue];
        }
    }
}
