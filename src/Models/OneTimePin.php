<?php

namespace Fintech\Auth\Models;

use Fintech\Core\Abstracts\BaseModel;
use Fintech\Core\Traits\BlameableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class OneTimePin extends BaseModel implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use BlameableTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    public const UPDATED_AT = null;

    protected $primaryKey = 'email';

    protected $keyType = 'string';
    protected $fillable = ['email', 'token', 'channel'];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */


    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
