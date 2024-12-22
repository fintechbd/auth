<?php

namespace Fintech\Auth\Http\Resources;

use Fintech\Core\Enums\Auth\FavouriteStatus;
use Fintech\Core\Supports\Constant;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class FavouriteCollection extends ResourceCollection
{
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
                'status' => FavouriteStatus::toArray(),
                'per_page' => Constant::PAGINATE_LENGTHS,
                'sort' => ['id', 'name', 'created_at', 'updated_at'],
            ],
            'query' => $request->all(),
        ];
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($favourite) {
            return [
                'id' => $favourite->getKey() ?? null,
                'sender_id' => $favourite->sender_id ?? null,
                'sender_name' => ($favourite->sender) ? $favourite->sender->name : null,
                'sender_mobile' => ($favourite->sender) ? $favourite->sender->mobile : null,
                'sender_email' => ($favourite->sender) ? $favourite->sender->email : null,
                'sender_photo' => ($favourite->sender) ? $favourite->sender?->getFirstMediaUrl('photo') : null,
                'receiver_id' => $favourite->receiver_id ?? null,
                'receiver_name' => ($favourite->receiver) ? $favourite->receiver->name : null,
                'receiver_email' => ($favourite->receiver) ? $favourite->receiver->email : null,
                'receiver_mobile' => ($favourite->receiver) ? $favourite->receiver->mobile : null,
                'receiver_photo' => ($favourite->receiver) ? $favourite->receiver?->getFirstMediaUrl('photo') : null,
                'name' => $favourite->name ?: (($favourite->receiver) ? $favourite->receiver->name : null),
                'status' => $favourite->status ?? null,
                'favourite_data' => $favourite->favourite_data,
                'created_at' => $favourite->created_at,
                'updated_at' => $favourite->updated_at,
            ];
        })->toArray();
    }
}
