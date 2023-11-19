<?php

namespace Fintech\Auth\Http\Resources;

use Carbon\Carbon;
use Fintech\Auth\Models\Profile;
use Fintech\Core\Facades\Core;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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
 * @property mixed $parent
 * @property mixed $parent_id
 * @property mixed $links
 * @method getKey()
 * @method getFirstMediaUrl(string $string)
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->getKey() ?? null,
            'parent_id' => $this->parent_id ?? null,
            'parent_name' => ($this->parent) ? $this->parent->name : null,
            'name' => $this->name ?? null,
            'mobile' => $this->mobile ?? null,
            'email' => $this->email ?? null,
            'login_id' => $this->login_id ?? null,
            'photo' => $this->getFirstMediaUrl('photo'),
            'status' => $this->status ?? null,
            'language' => $this->language ?? null,
            'currency' => $this->currency ?? null,
            'app_version' => $this->app_version ?? null,
            'roles' => ($this->roles) ? $this->roles->toArray() : [],
            'links' => $this->links,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
        unset($data['roles'][0]['links'],$data['roles'][0]['pivot'],$data['roles'][0]['permissions']);

        /**
         * @var Profile $profile
         */
        $profile = $this->profile;

        $profile_data = [
            'profile_data' => $profile->user_profile_data ?? null,
            'id_doc' => [
                'id_type' => $profile->id_type ?? null,
                'id_no' => $profile->id_no ?? null,
                'id_issue_country' => $profile->id_issue_country ?? null,
                'id_expired_at' => $profile->id_expired_at ?? null,
                'id_issue_at' => $profile->id_issue_at ?? null,
                'id_no_duplicate' => $profile->id_no_duplicate ?? null,
                'documents' => $this->formatMediaCollection($profile->getMedia('documents')),
            ],
            'date_of_birth' => $profile->date_of_birth ?? null,
            "permanent_address" => [
                'address' => $profile->permanent_address ?? null,
                'city_id' => $profile->city_id ?? null,
                'city_name' => null,
                'state_id' => $profile->state_id ?? null,
                'state_name' => null,
                'country_id' => $profile->country_id ?? null,
                'country_name' => null,
                'post_code' => $profile->post_code ?? null,
            ],
            "present_address" => [
                'address' => $profile->present_address ?? null,
                'city_id' => $profile->present_city_id ?? null,
                'city_name' => null,
                'state_id' => $profile->present_state_id ?? null,
                'state_name' => null,
                'country_id' => $profile->present_country_id ?? null,
                'country_name' => null,
                'post_code' => $profile->present_post_code ?? null,
            ],
            'blacklisted' => $profile->blacklisted ?? null,
            'proof_of_address' => $this->formatMediaCollection($profile->getMedia('proof_of_address'))
        ];

        if (Core::packageExists('MetaData')) {
            $profile_data['permanent_address']['city_name'] = $profile->city?->name ?? null;
            $profile_data['permanent_address']['state_name'] = $profile->state?->name ?? null;
            $profile_data['permanent_address']['country_name'] = $profile->country?->name ?? null;
            $profile_data['present_address']['city_name'] = $profile->presentCity?->name ?? null;
            $profile_data['present_address']['state_name'] = $profile->presentState?->name ?? null;
            $profile_data['present_address']['country_name'] = $profile->presentCountry?->name ?? null;
        }

        return array_merge($data, $profile_data);
    }

    private function formatMediaCollection($collection): array
    {
        $data = [];

        $collection->each(function (Media $media) use (&$data) {
            $data[$media->getCustomProperty('type')][$media->getCustomProperty('side')] = $media->getFullUrl();
        });

        return $data;
    }
}
