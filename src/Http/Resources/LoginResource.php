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
        $this->resource->load([
            'profile.country', 'profile.state', 'profile.city',
            'profile.presentCountry', 'profile.presentState', 'profile.presentCity',
        ]);

        return [
            'id' => $this->id ?? null,
            'name' => $this->name ?? null,
            'mobile' => $this->mobile ?? null,
            'email' => $this->email ?? null,
            'login_id' => $this->login_id ?? null,
            'status' => $this->status ?? null,
            'language' => $this->language ?? null,
            'currency' => $this->currency ?? null,
            'app_version' => $this->app_version ?? null,
            'total_balance' => 0,
            'email_verified_at' => $this->email_verified_at ?? null,
            'mobile_verified_at' => $this->mobile_verified_at ?? null,
            'created_at' => $this->created_at ?? null,
            'updated_at' => $this->updated_at ?? null,
            'profile' => (($this->profile != null)
                ? [
                    'user_profile_data' => $this->profile->user_profile_data ?? null,
                    'id_type' => $this->profile->id_type ?? null,
                    'id_no' => $this->profile->id_no ?? null,
                    'id_issue_country' => $this->profile->id_issue_country ?? null,
                    'id_expired_at' => $this->profile->id_expired_at ?? null,
                    'id_issue_at' => $this->profile->id_issue_at ?? null,
                    'id_no_duplicate' => $this->profile->id_no_duplicate ?? null,
                    'date_of_birth' => $this->profile->date_of_birth ?? null,
                    'address' => $this->profile->permanent_address ?? null,
                    'city_id' => $this->profile->city_id ?? null,
                    'city_name' => $this->profile->city->name ?? null,
                    'state_id' => $this->profile->state_id ?? null,
                    'state_name' => $this->profile->state->name ?? null,
                    'country_id' => $this->profile->country_id ?? null,
                    'country_name' => $this->profile->country->name ?? null,
                    'post_code' => $this->profile->post_code ?? null,
                    'present_address' => $this->profile->present_address ?? null,
                    'present_city_id' => $this->profile->present_city_id ?? null,
                    'present_city_name' => $this->profile->presentCity->name ?? null,
                    'present_state_id' => $this->profile->present_state_id ?? null,
                    'present_state_name' => $this->profile->presentState_name ?? null,
                    'present_country_id' => $this->profile->present_country_id ?? null,
                    'present_country_name' => $this->profile->presentCountry_name ?? null,
                    'present_post_code' => $this->profile->present_post_code ?? null,

                    'blacklisted' => $this->profile->blacklisted ?? null,
                    'created_at' => $this->profile->created_at ?? null,
                    'updated_at' => $this->profile->updated_at ?? null,
                ]
                : (new \stdClass())),
        ];
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @return array<string, mixed>
     */
    public function with(Request $request): array
    {
        $origin = Str::slug(config('app.name'));

        return [
            'access' => [
                'token' => $this->createToken($origin)->plainTextToken,
                'type' => 'bearer',
                'permissions' => [
                    'login',
                    'dashboard',
                ],
            ],
            'message' => trans('auth::messages.success'),
        ];
    }
}
