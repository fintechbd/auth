<?php

namespace Fintech\Auth\Http\Resources;

use Fintech\Core\Facades\Core;
use Illuminate\Http\Resources\Json\JsonResource;

class IdDocTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->getKey(),
            'country_id' => $role->country_id ?? null,
            'country_name' => null,
            'name' => $this->name ?? null,
            'code' => $this->code ?? null,
            'sides' => $this->sides ?? null,
            'enabled' => $this->enabled ?? null,
            'id_doc_type_data' => $this->id_doc_type_data ?? null,
            'links' => $this->links,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

        if (Core::packageExists('MetaData')) {
            $data['country_name'] = $this->country->name ?? null;
        }
        return $data;
    }
}
