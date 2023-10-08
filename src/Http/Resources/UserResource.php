<?php

namespace Fintech\Auth\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
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
