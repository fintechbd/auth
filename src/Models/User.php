<?php

namespace Fintech\Auth\Models;


use Fintech\Core\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class User
 * @package Fintech\Auth\Models
 * @method getTeamIdFromToken()
 */
class User extends Authenticatable
{

    use HasApiTokens;
    use HasRoles;
    use AuditableTrait;
    use SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $primaryKey = 'id';

    protected $guarded = ['id'];

    protected $casts = ['restored_at' => 'datetime', 'email_verified_at' => 'datetime', 'mobile_verified_at' => 'datetime', 'wrong_password' => 'integer',];

    protected $attributes = [
        'wrong_password' => 0,
        'wrong_pin' => 0,
    ];

    protected $hidden = ['creator_id', 'editor_id', 'destroyer_id', 'restorer_id'];

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

    public function profile(): HasOne
    {
        return $this->hasOne(config('fintech.auth.user_profile_model'));
    }

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
