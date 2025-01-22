<?php

namespace Fintech\Auth\Models;

use Fintech\Auth\Traits\TransactionRelations;
use Fintech\Core\Enums\Auth\RiskProfile;
use Fintech\Core\Traits\Audits\BlameableTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use InvalidArgumentException;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class User
 * @package Fintech\Auth\Models
 * @method getTeamIdFromToken()
 * @property Collection $tokens
 * @property int $wrong_password
 */
class User extends Authenticatable implements HasMedia, Auditable
{
    use \OwenIt\Auditing\Auditable;
    use BlameableTrait;
    use HasApiTokens;
    use HasRoles;
    use SoftDeletes;
    use Notifiable;
    use InteractsWithMedia;
    use TransactionRelations;


    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $primaryKey = 'id';

    protected $guarded = ['id'];

    protected $casts = [
        'restored_at' => 'datetime',
        'email_verified_at' => 'datetime',
        'mobile_verified_at' => 'datetime',
        'logged_in_at' => 'datetime',
        'logged_out_at' => 'datetime',
        'wrong_password' => 'integer',
        'risk_profile' => RiskProfile::class,
    ];

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

    public function authField()
    {
        $authField = config('fintech.auth.auth_field', 'login_id');

        if ($this->{$authField} != null) {
            return $this->{$authField};
        }

        throw new InvalidArgumentException("Invalid authentication field ($authField) configured for User.");

    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photo')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'image/svg+xml'])
            ->useFallbackUrl(asset(config('fintech.auth.user_image', 'vendor/auth/img/anonymous-user.png')))
            ->useDisk(config('filesystems.default', 'public'))
            ->singleFile();
    }

    /**
     * Route notifications for the Push Message channel.
     */
    public function routeNotificationForPush($notification = null): mixed
    {
        return $this->fcm_token;
    }

    /**
     * Route notifications for the Push Message channel.
     */
    public function routeNotificationForSms($notification = null): mixed
    {
        return $this->mobile;
    }

    /**
     * Route notifications for the Mail Message channel.
     */
    public function routeNotificationForMail($notification = null): mixed
    {
        return [$this->email => $this->name];
    }

    /**
     * Route notifications for the Push Message channel.
     */
    public function routeNotificationForChat($notification = null): mixed
    {
        return $this->getKey() . '_';
    }


    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }

    public function profile(): HasOne
    {
        return $this->hasOne(config('fintech.auth.profile_model'));
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

    /**
     * return all resource link for this object
     *
     * @return array[]
     */
    public function getLinksAttribute()
    {
        $primaryKey = $this->getKey();

        $links = [
            'show' => action_link(route('auth.users.show', $primaryKey), __('core::messages.action.show'), 'get'),
            'update' => action_link(route('auth.users.update', $primaryKey), __('core::messages.action.update'), 'put'),
            'destroy' => action_link(route('auth.users.destroy', $primaryKey), __('core::messages.action.destroy'), 'delete'),
            'restore' => action_link(route('auth.users.restore', $primaryKey), __('core::messages.action.restore'), 'post'),
            'reset-pin' => action_link(route('auth.users.reset-password-pin', [$primaryKey, 'pin']), __('auth::messages.reset.button.pin'), 'post'),
            'reset-password' => action_link(route('auth.users.reset-password-pin', [$primaryKey, 'password']), __('auth::messages.reset.button.password'), 'post'),
            'reset-both' => action_link(route('auth.users.reset-password-pin', [$primaryKey, 'both']), __('auth::messages.reset.button.both'), 'post'),
        ];

        if ($this->getAttribute('deleted_at') == null) {
            unset($links['restore']);
        } else {
            unset($links['destroy']);
        }

        return $links;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
