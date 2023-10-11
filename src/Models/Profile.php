<?php

namespace Fintech\Auth\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Profile extends Model
{

    use \Fintech\Core\Traits\AuditableTrait;
    use SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $primaryKey = 'id';

    protected $fillable = [];

    protected $guarded = ['id'];

    protected $casts = [ 'restored_at' => 'datetime', 'date_of_birth' => 'datetime', 'user_profile_data' => 'json'];

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
     * Permanent Address
     */
    public function country()
    {
        return $this->belongsTo(config('fintech.metadata.country_model'));
    }

    public function state()
    {
        return $this->belongsTo(config('fintech.metadata.state_model'));
    }

    public function city()
    {
        return $this->belongsTo(config('fintech.metadata.city_model'));
    }

    /**
     * Present Address
     */
    public function presentCountry()
    {
        return $this->belongsTo(config('fintech.metadata.country_model'), 'present_country_id');
    }

    public function presentState()
    {
        return $this->belongsTo(config('fintech.metadata.state_model'), 'present_state_id');
    }

    public function presentCity()
    {
        return $this->belongsTo(config('fintech.metadata.city_model'), 'present_city_id');
    }

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
