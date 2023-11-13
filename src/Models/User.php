<?php

namespace Fintech\Auth\Models;

use Fintech\Auth\Traits\TransactionRelations;
use Fintech\Core\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class User
 * @package Fintech\Auth\Models
 * @method getTeamIdFromToken()
 */
class User extends Authenticatable implements HasMedia
{
    use HasApiTokens;
    use HasRoles;
    use AuditableTrait;
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

    protected $casts = ['restored_at' => 'datetime', 'email_verified_at' => 'datetime', 'mobile_verified_at' => 'datetime', 'wrong_password' => 'integer',];

    protected $attributes = [
        'wrong_password' => 0,
        'wrong_pin' => 0,
    ];

    protected $hidden = ['creator_id', 'editor_id', 'destroyer_id', 'restorer_id'];

    protected $appends = ['links'];

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

        throw new \InvalidArgumentException("Invalid authentication field ($authField) configured for User.");

    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photo')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'image/svg+xml'])
            ->useFallbackUrl(asset('storage/images/anonymous-user.jpg'))
            ->useFallbackPath(storage_path('/app/public/images/anonymous-user.jpg'))
            ->useFallbackUrl(asset('storage/images/anonymous-user.jpg'), 'thumb')
            ->useFallbackPath(storage_path('/app/public/images/anonymous-user.jpg'), 'thumb')
            ->useDisk(config('filesystems.default', 'public'))
            ->singleFile();
    }

    /**
     * Route notifications for the Push Message channel.
     */
    public function routeNotificationForPush(Notification $notification): mixed
    {
        return $this->fcm_token;
    }
    /**
     * Route notifications for the Push Message channel.
     */
    public function routeNotificationForSms(Notification $notification): mixed
    {
        return $this->mobile;
    }
    /**
     * Route notifications for the Push Message channel.
     */
    public function routeNotificationForMail(Notification $notification): mixed
    {
        return $this->email;
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
