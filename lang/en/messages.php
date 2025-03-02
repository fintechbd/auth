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
    'forbidden' => 'Access denied! You don’t have permission for :permission',
    'logout' => 'Logged out. Thanks for using :app_name!',
    'failed' => 'These credentials do not match our records.',
    'password' => 'Incorrect password.',
    'throttle' => 'Too many request attempts. Please try again in :seconds seconds.',
    'ip_blocked' => 'Your IP :ip is blocked, Please contact support.',
    'warning' => 'Wrong credentials! You have used :attempt out of :threshold attempts.',
    'lockup' => 'Your account is locked. Please contact support.',
    'update_password' => 'New password updated successfully.',
    'update_pin' => 'New pin updated successfully.',
    'update_photo' => 'New profile photo updated successfully.',
    'user_profile_update' => 'User :fields updated successfully.',
    'account_deleted' => 'Account deletion request sent successfully.',
    'reset' => [
        'success' => 'Your account password reset successful.',
        'temporary_password' => 'A temporary password has been sent. Log in with your new credentials.',
        'reset_link' => 'A password reset link has been sent. Follow the instructions to proceed.',
        'otp' => 'A verification code has been sent. Verify your account with the code.',
        'notification_failed' => 'Error processing your request. Try again later.',
        'invalid_token' => 'The reset link token is invalid. Please try again later.',
        'expired_token' => 'The password reset token has expired. Please try again later.',
        'user_not_found' => 'No user found for this request.',
        'button' => [
            'pin' => 'Reset Pin',
            'password' => 'Reset Password',
            'both' => 'Reset Password & Pin',
        ]
    ],
    'verify' => [
        'link' => 'A password reset link has been sent via :channel. Follow the instructions to proceed.',
        'otp' => 'A verification code has been sent via :channel. Enter the code to verify your account',
        'failed' => 'Error processing your request. Try again later.',
        'invalid' => 'The verification link token is invalid. Please try again later.',
        'expired' => 'The verification token has expired. Please try again later.',
        'success' => 'OTP Verification successful.',
        'field_empty' => 'Input field must be one of (mobile, email, user) is not present or value is empty.'
    ],
    'audit' => [
        'create' => 'System audit can not be created by user input.',
        'update' => 'System audit can not be updated by user input.',
        'restore' => 'System audit can not be restored by user command.'
    ],
    'role' => [
        'permission_assigned' => 'Assigning permission to :role group successful.'
    ],
    'user' => [
        'status-change' => 'User Account status changed to :status successfully.'
    ],
    'favourite' => [
        'already_exists' => "Sorry, This user is already on favourite! Please choose another one.",
        'requested' => 'Favourite request has been sent.',
        'accepted' => 'Favourite request has been accepted.',
        'rejected' => 'Favourite request has been canceled.',
        'blocked' => 'This favourite request has been blocked.',
    ]
];
