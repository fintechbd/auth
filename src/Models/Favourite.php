<?php

namespace Fintech\Auth\Models;

use Fintech\Core\Abstracts\BaseModel;
use Fintech\Core\Enums\Auth\FavouriteStatus;
use Fintech\Core\Traits\Audits\BlameableTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Favourite extends BaseModel implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use BlameableTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $primaryKey = 'id';

    protected $guarded = ['id'];


    protected $casts = ['favourite_data' => 'array', 'restored_at' => 'datetime', 'enabled' => 'bool', 'status' => FavouriteStatus::class];

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

    public function sender(): BelongsTo
    {
        return $this->belongsTo(config('fintech.auth.user_model', User::class), 'sender_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(config('fintech.auth.user_model', User::class), 'receiver_id');
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
     * @return array
     */
    public function getLinksAttribute()
    {
        $primaryKey = $this->getKey();

        $links = [
            'show' => action_link(route('auth.favourites.show', $primaryKey), __('core::messages.action.show'), 'get'),
            'update' => action_link(route('auth.favourites.update', $primaryKey), __('core::messages.action.update'), 'put'),
            'destroy' => action_link(route('auth.favourites.destroy', $primaryKey), __('core::messages.action.destroy'), 'delete'),
            'restore' => action_link(route('auth.favourites.restore', $primaryKey), __('core::messages.action.restore'), 'post'),
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
