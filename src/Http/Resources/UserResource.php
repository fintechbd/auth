<?php

namespace Fintech\Auth\Http\Resources;

use Carbon\Carbon;
use Fintech\Auth\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

/**
 * Class UserResource
 * @package Fintech\Auth\Http\Resources
 *
 * @property-read int $id
 * @property-read string $name
 * @property-read string $mobile
 * @property-read string $email
 * @property-read string $login_id
 * @property-read string $status
 * @property-read string $language
 * @property-read string $currency
 * @property-read string $app_version
 * @property-read float $total_balance
 * @property-read Collection $roles
 * @property-read Profile|null $profile
 * @property-read Carbon $email_verified_at
 * @property-read Carbon $mobile_verified_at
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->getKey(),
            'name' => $this->name,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'login_id' => $this->login_id,
            'status' => $this->status,
            'language' => $this->language,
            'currency' => $this->currency,
            'app_version' => $this->app_version,
            'total_balance' => 0,
            'roles' => $this->roles,
            'email_verified_at' => $this->email_verified_at,
            'mobile_verified_at' => $this->mobile_verified_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'profile' => (($this->profile != null)
                ? (new ProfileResource($this->profile))
                : (new \stdClass())),
        ];
    }
}
