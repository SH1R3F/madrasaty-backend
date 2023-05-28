<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\ClassroomResource;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return array_merge(
            parent::toArray($request),
            [
                'classroom' => new ClassroomResource($this->whenLoaded('classroom'))
            ]
        );
    }
}
