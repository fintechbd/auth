<?php

namespace Fintech\Auth\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FavouriteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->getKey() ?? null,
            'sender_id' => $this->sender_id ?? null,
            'sender_name' => ($this->sender) ? $this->sender->name : null,
            'sender_photo' => ($this->sender) ? $this->sender?->getFirstMediaUrl('photo') : null,
            'receiver_id' => $this->receiver_id ?? null,
            'receiver_name' => ($this->receiver) ? $this->receiver->name : null,
            'receiver_photo' => ($this->receiver) ? $this->receiver?->getFirstMediaUrl('photo') : null,
            'name' => $this->name ?? ($this->receiver) ? $this->receiver->name : null,
            'status' => $this->status ?? null,
            'favourite_data' => $this->favourite_data,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
