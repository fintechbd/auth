<?php

namespace Fintech\Auth\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VerifyIdDocTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'valid' => $this->resource == null
        ];
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array<string, mixed>
     */
    public function with(\Illuminate\Http\Request $request): array
    {
        return [
            'message' => ($this->resource == null)
                ? 'This ID Document is valid.'
                : 'This ID Document is already exists with other account.',
            'query' => $request->all(),
        ];
    }
}
