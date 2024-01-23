<?php

namespace App\Http\Resources\Api\V1;

use App\Models\Task as TaskModel;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var TaskModel $this */
        return [
            'id' => $this->id,
            'name' => $this->name,
            'desc' => $this->desc,
            'updated_at' => new DateTime($this->updated_at),
            'created_at' => new DateTime($this->created_at),
        ];
    }
}
