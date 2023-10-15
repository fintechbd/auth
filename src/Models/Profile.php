<?php

namespace Fintech\Auth\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Fintech\Auth\Traits\MetaDataRelations;

class Profile extends Model
{
    use \Fintech\Core\Traits\AuditableTrait;
    use SoftDeletes;
    use MetaDataRelations;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $primaryKey = 'id';

    protected $fillable = [];

    protected $guarded = ['id'];

    protected $casts = [ 'restored_at' => 'datetime', 'date_of_birth' => 'datetime', 'id_expired_at' => 'datetime', 'id_issue_at' => 'datetime', 'user_profile_data' => 'array'];

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

    /**
     * Parental Access
     */
    public function user()
    {
        return $this->belongsTo(config('fintech.auth.user_model'));
    }

    public function approver()
    {
        return $this->belongsTo(config('fintech.auth.user_model'), 'approver_id');
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
