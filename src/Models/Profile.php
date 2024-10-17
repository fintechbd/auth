<?php

namespace Fintech\Auth\Models;

use Fintech\Auth\Traits\MetaDataRelations;
use Fintech\Core\Abstracts\BaseModel;
use Fintech\Core\Traits\BlameableTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Profile extends BaseModel implements HasMedia, Auditable
{
    use \OwenIt\Auditing\Auditable;
    use BlameableTrait;
    use SoftDeletes;
    use MetaDataRelations;
    use InteractsWithMedia;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $primaryKey = 'id';

    protected $guarded = ['id'];

    protected $casts = ['restored_at' => 'datetime', 'date_of_birth' => 'datetime', 'id_expired_at' => 'datetime', 'id_issue_at' => 'datetime', 'user_profile_data' => 'array'];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('documents')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'])
            ->useDisk(config('filesystems.default', 'public'));

        $this->addMediaCollection('proof_of_address')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'])
            ->useDisk(config('filesystems.default', 'public'));
    }

    /**
     * this method is used by media library to upload file
     *
     * @param $file
     * @return array<string, array>
     */
    public function documentsMediaResolve($file)
    {
        $attributes = ['type' => $file['type']];

        if (isset($file['front'])) {
            $attributes['side'] = "front";
            return [$file['front'], $attributes];
        }

        if (isset($file['back'])) {
            $attributes['side'] = "back";
            return [$file['back'], $attributes];
        }

        return [$file, $attributes];
    }

    /**
     * this method is used by media library to upload file
     *
     * @param $file
     * @return array<string, array>
     */
    public function proofOfAddressMediaResolve($file)
    {
        $attributes = ['type' => $file['type']];

        if (isset($file['front'])) {
            $attributes['side'] = "front";
            return [$file['front'], $attributes];
        }

        if (isset($file['back'])) {
            $attributes['side'] = "back";
            return [$file['back'], $attributes];
        }

        return [$file, $attributes];
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * Parental Access
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(config('fintech.auth.user_model'));
    }

    public function approver(): BelongsTo
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
