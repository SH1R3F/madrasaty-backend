<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\StudentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ClassroomResource extends JsonResource
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
                'students' => StudentResource::collection($this->whenLoaded('students'))
            ]
        );
    }
}
