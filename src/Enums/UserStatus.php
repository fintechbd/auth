<?php

namespace Fintech\Auth\Enums;

enum UserStatus: string
{
    case Active =  'ACTIVE';
    case InActive =  'IN-ACTIVE';
    case Banned =  'BANNED';
    case Flagged =  'FLAGGED';
    case Terminated =  'TERMINATED';
}
