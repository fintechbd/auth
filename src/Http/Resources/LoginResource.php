<?php

namespace Fintech\Auth\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class LoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request
     * @return array
     */
    public function toArray($request)
    {
        $this->resource->load(['profile', 'roles']);

        $return = [
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
            'role_id' => null,
            'role_name' => null,
            'email_verified_at' => $this->email_verified_at,
            'mobile_verified_at' => $this->mobile_verified_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'profile' => (($this->profile != null)
                ? (new ProfileResource($this->profile))
                : (new \stdClass())),
        ];

        if ($this->roles != null) {
            $role = $this->roles->first();
            $return['role_id'] = $role->id ?? null;
            $return['role_name'] = $role->name ?? null;
        }

        return $return;
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @return array<string, mixed>
     */
    public function with(Request $request): array
    {
        $origin = Str::slug(config('app.name'));

        $permissions = [];

        $permissionCollection = $this->getAllPermissions();

        if (!$permissionCollection->isEmpty()) {
            $permissions = $permissionCollection->pluck('name')->toArray();
        }


        return [
            'access' => [
                'token' => $this->createToken($origin)->plainTextToken,
                'type' => 'bearer',
                'permissions' => $permissions,
            ],
            'message' => trans('auth::messages.success'),
        ];
    }
}
