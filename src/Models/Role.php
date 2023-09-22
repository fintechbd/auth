<?php

namespace Fintech\Auth\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Fintech\Core\Traits\BlameableTrait;

class Role extends Model implements Auditable
{
   use \OwenIt\Auditing\Auditable;
   use SoftDeletes;
   use BlameableTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $primaryKey = 'id';
    protected $fillable = [];
    protected $guarded = ['id'];
    protected $hidden = ['creator_id', 'editor_id', 'destroyer_id', 'creator_type', 'editor_type', 'destroyer_type', 'restorer_type', 'restorer_id', 'deleted_at'];
    protected $casts = [];

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
