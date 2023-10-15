<?php

namespace Fintech\Auth\Http\Resources;

use Carbon\Carbon;
use Fintech\Auth\Models\Profile;
use Fintech\Core\Facades\Core;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

/**
 * Class ProfileResource
 * @package Fintech\Auth\Http\Resources
 *
 * @property-read mixed $profile_data
 * @property-read string $id_type
 * @property-read string|int $id_no
 * @property-read string $id_issue_country
 * @property-read Carbon $id_expired_at
 * @property-read Carbon $id_issue_at
 * @property-read bool $id_no_duplicate
 * @property-read Carbon $date_of_birth
 * @property-read string $app_version
 * @property-read float $total_balance
 * @property-read Collection $roles
 * @property-read Profile|null $profile
 * @property-read Carbon $email_verified_at
 * @property-read Carbon $mobile_verified_at
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 */
class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request
     * @return array
     */
    public function toArray($request)
    {
        $profile = [
            'user_profile_data' => $this->user_profile_data ?? null,
            'id_type' => $this->id_type ?? null,
            'id_no' => $this->id_no ?? null,
            'id_issue_country' => $this->id_issue_country ?? null,
            'id_expired_at' => $this->id_expired_at ?? null,
            'id_issue_at' => $this->id_issue_at ?? null,
            'id_no_duplicate' => $this->id_no_duplicate ?? null,
            'date_of_birth' => $this->date_of_birth ?? null,
            'address' => $this->permanent_address ?? null,
            'city_id' => $this->city_id ?? null,
            'city_name' => null,
            'state_id' => $this->state_id ?? null,
            'state_name' => null,
            'country_id' => $this->country_id ?? null,
            'country_name' => null,
            'post_code' => $this->post_code ?? null,
            'present_address' => $this->present_address ?? null,
            'present_city_id' => $this->present_city_id ?? null,
            'present_city_name' => null,
            'present_state_id' => $this->present_state_id ?? null,
            'present_state_name' => null,
            'present_country_id' => $this->present_country_id ?? null,
            'present_country_name' => null,
            'present_post_code' => $this->present_post_code ?? null,
            'blacklisted' => $this->blacklisted ?? null,
            'created_at' => $this->created_at ?? null,
            'updated_at' => $this->updated_at ?? null,
        ];

        if (Core::packageExists('MetaData')) {

            $this->resource->load([
                'country', 'state', 'city',
                'presentCountry', 'presentState', 'presentCity',
            ]);

            $profile['city_name'] = $this->city->name ?? null;
            $profile['state_name'] = $this->state->name ?? null;
            $profile['country_name'] = $this->country->name ?? null;
            $profile['present_city_name'] = $this->presentCity->name ?? null;
            $profile['present_state_name'] = $this->presentState->name ?? null;
            $profile['present_country_name'] = $this->presentCountry->name ?? null;
        }

        return $profile;
    }
}
