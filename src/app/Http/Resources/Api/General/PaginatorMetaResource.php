<?php

namespace App\Http\Resources\Api\General;

use Illuminate\Http\Resources\Json\JsonResource;

final class PaginatorMetaResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'current_page' => $this->currentPage(),
            'last_page' => $this->lastPage(),
            'per_page' => $this->perPage(),
            'total' => $this->total(),
            'from' => $this->firstItem(),
            'to' => $this->lastItem(),
        ];
    }
}
