<?php

namespace Fintech\Auth\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request
     * @return array
     */
    public function toArray($request)
    {
        return [
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
            'city_name' => $this->city->name ?? null,
            'state_id' => $this->state_id ?? null,
            'state_name' => $this->state->name ?? null,
            'country_id' => $this->country_id ?? null,
            'country_name' => $this->country->name ?? null,
            'post_code' => $this->post_code ?? null,
            'present_address' => $this->present_address ?? null,
            'present_city_id' => $this->present_city_id ?? null,
            'present_city_name' => $this->presentCity->name ?? null,
            'present_state_id' => $this->present_state_id ?? null,
            'present_state_name' => $this->presentState->name ?? null,
            'present_country_id' => $this->present_country_id ?? null,
            'present_country_name' => $this->presentCountry->name ?? null,
            'present_post_code' => $this->present_post_code ?? null,
            'blacklisted' => $this->blacklisted ?? null,
            'created_at' => $this->created_at ?? null,
            'updated_at' => $this->updated_at ?? null,
        ];
    }
}
