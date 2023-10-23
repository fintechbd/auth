<?php
/*
|--------------------------------------------------------------------------
| Meta Data Language Lines
|--------------------------------------------------------------------------
|
| The following language lines are used during authentication for various
| messages that we need to display to the user. You are free to modify
| these language lines according to your application's requirements.
|
*/
return [
    'success' => 'Login successful.',
    'forbidden' => 'Access Forbidden! You are not allowed to :permission',
    'logout' => 'Logout successful. Thank you for using our services',
    'failed' => 'These credentials do not match our records.',
    'password' => 'The provided password is incorrect.',
    'throttle' => 'Too many request attempts. Please try again in :seconds seconds.',
    'ip_blocked' => 'Your IP :ip is blocked, Please contact support.',
    'warning' => 'Sorry, You entered wrong credentials! You already attempt :attempt. times out of :threshold',
    'lockup' => 'Sorry, Your Account is has been Locked. Please contact support!',
    'reset' => [
        'success' => 'Your account password reset successful.',
        'temporary_password' => 'We have send you a temporary password. Please log into you account with credentials.',
        'reset_link' => 'We have send you a password reset link. Please follow that instruction to proceed.',
        'otp' => 'We have send you a verification code. Please verify your account with given code.',
        'notification_failed' => 'There is a error while processing your request. Please try again later',
        'invalid_token' => 'The reset link token is invalid. Please try again later.',
        'expired_token' => 'The password reset token has expired. Please try again later.',
        'user_not_found' => 'Unable to find valid user associated with this token',
        'button' => [
            'pin' => 'Reset Pin',
            'password' => 'Reset Password',
            'both' => 'Reset Password & Pin',
        ]
    ],
    'verify' => [
        'link' => 'We have send you a password reset link. Please follow that instruction to proceed.',
        'otp' => 'We have send you a verification code. Please verify your account with given code.',
        'failed' => 'There is a error while processing your request. Please try again later',
        'invalid' => 'The verification link token is invalid. Please try again later.',
        'expired' => 'The verification token has expired. Please try again later.',
        'success' => 'OTP Verification successful.',
    ]
];
