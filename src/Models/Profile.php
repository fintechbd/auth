<?php

namespace Fintech\Auth\Models;

use Fintech\Auth\Traits\MetaDataRelations;
use Fintech\Core\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Profile extends Model implements HasMedia
{
    use AuditableTrait;
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
