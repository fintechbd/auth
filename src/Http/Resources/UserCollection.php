<?php

namespace Fintech\Auth\Http\Resources;

use Fintech\Core\Facades\Core;
use Fintech\Core\Supports\Constant;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($user) {
            $data = [
                'id' => $user->id ?? null,
                'parent_id' => $user->parent_id ?? null,
                'parent_name' => ($user->parent) ? $user->parent->name : null,
                'name' => $user->name ?? null,
                'mobile' => $user->mobile ?? null,
                'email' => $user->email ?? null,
                'login_id' => $user->login_id ?? null,
                'wrong_password' => $user->wrong_password ?? null,
                'wrong_pin' => $user->wrong_pin ?? null,
                'status' => $user->status ?? null,
                'language' => $user->language ?? null,
                'currency' => $user->currency ?? null,
                'app_version' => $user->app_version ?? null,
                'remember_token' => $user->remember_token ?? null,
                'fcm_token' => $user->fcm_token ?? null,
                'roles' => ($user->roles) ? $user->roles : [],
                'links' => $user->links,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ];

            $profile = $user->profile;

            $profile_data = [
                'profile_photo' => $user->getFirstMediaUrl('profile_data'),
                'user_profile_data' => $profile->user_profile_data ?? null,
                'id_type' => $profile->id_type ?? null,
                'id_no' => $profile->id_no ?? null,
                'id_issue_country' => $profile->id_issue_country ?? null,
                'id_expired_at' => $profile->id_expired_at ?? null,
                'id_issue_at' => $profile->id_issue_at ?? null,
                'id_no_duplicate' => $profile->id_no_duplicate ?? null,
                'date_of_birth' => $profile->date_of_birth ?? null,
                'address' => $profile->permanent_address ?? null,
                'city_id' => $profile->city_id ?? null,
                'city_name' => null,
                'state_id' => $profile->state_id ?? null,
                'state_name' => null,
                'country_id' => $profile->country_id ?? null,
                'country_name' => null,
                'post_code' => $profile->post_code ?? null,
                'present_address' => $profile->present_address ?? null,
                'present_city_id' => $profile->present_city_id ?? null,
                'present_city_name' => null,
                'present_state_id' => $profile->present_state_id ?? null,
                'present_state_name' => null,
                'present_country_id' => $profile->present_country_id ?? null,
                'present_country_name' => null,
                'present_post_code' => $profile->present_post_code ?? null,
                'blacklisted' => $profile->blacklisted ?? null,
            ];

            if (class_exists(\Fintech\MetaData\Facades\MetaData::class)) {

                $profile_data['city_name'] = $profile->city?->name ?? null;
                $profile_data['state_name'] = $profile->state?->name ?? null;
                $profile_data['country_name'] = $profile->country?->name ?? null;
                $profile_data['present_city_name'] = $profile->presentCity?->name ?? null;
                $profile_data['present_state_name'] = $profile->presentState?->name ?? null;
                $profile_data['present_country_name'] = $profile->presentCountry?->name ?? null;
            }

            return array_merge($data, $profile_data);

        })->toArray();
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @return array<string, mixed>
     */
    public function with(Request $request): array
    {
        return [
            'options' => [
                'dir' => Constant::SORT_DIRECTIONS,
                'per_page' => Constant::PAGINATE_LENGTHS,
                'sort' => ['id', 'name', 'created_at', 'updated_at'],
            ],
            'query' => $request->all(),
        ];
    }
}
