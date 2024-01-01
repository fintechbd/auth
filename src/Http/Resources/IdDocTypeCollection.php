<?php

namespace Fintech\Auth\Http\Resources;

use Fintech\Core\Facades\Core;
use Fintech\Core\Supports\Constant;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class IdDocTypeCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($idDoc) {
            $data = [
                'id' => $idDoc->getKey(),
                'country_id' => $idDoc->country_id ?? null,
                'country_name' => null,
                'name' => $idDoc->name ?? null,
                'code' => $idDoc->code ?? null,
                'sides' => $idDoc->sides ?? null,
                'enabled' => $idDoc->enabled ?? null,
                'id_doc_type_data' => $idDoc->id_doc_type_data ?? null,
                'links' => $idDoc->links,
                'created_at' => $idDoc->created_at,
                'updated_at' => $idDoc->updated_at,
            ];

            if (Core::packageExists('MetaData')) {
                $data['country_name'] = $idDoc->country->name ?? null;
            }
            return $data;
        })->toArray();
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param Request $request
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
