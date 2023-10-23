<?php

namespace Fintech\Auth\Enums;

enum OTPOption: string
{
    case
    Link = 'link';
    case
    Otp = 'otp';
}
