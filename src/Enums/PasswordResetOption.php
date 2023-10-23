<?php

namespace Fintech\Auth\Enums;

enum PasswordResetOption: string
{
    case
    TemporaryPassword = 'temporary_password';
    case
    ResetLink = 'reset_link';
    case
    Otp = 'otp';
}
