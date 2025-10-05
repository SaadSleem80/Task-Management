<?php

namespace App\Http\Resources\Tasks;

use App\Http\Resources\Users\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'title'         => $this->title,
            'description'   => $this->description,
            'user'          => UserResource::make($this->whenLoaded('user')),
            'parent'        => TaskResource::make($this->whenLoaded('parent')),
            'sub_tasks'     => TaskResource::collection($this->whenLoaded('allChildren')),
            'status'        => $this->status,
            'due_date'      => $this->due_date,
            'created_at'    => $this->created_at->toDateTimeString(),
            'updated_at'    => $this->updated_at->toDateTimeString(),
        ];
    }
}
