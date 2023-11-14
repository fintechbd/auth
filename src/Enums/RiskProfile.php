<?php

namespace Fintech\Auth\Enums;

enum RiskProfile:string
{
    case
    Low = 'green';
    case
    Moderate = 'yellow';
    case
    High = 'red';
}
