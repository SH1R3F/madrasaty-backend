<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Resources\StudentResource;
use App\Http\Resources\ClassroomResource;
use Illuminate\Http\Resources\Json\JsonResource;

class NoteResource extends JsonResource
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
                'classroom' => new ClassroomResource($this->whenLoaded('classroom')),
                'student' => new StudentResource($this->whenLoaded('student')),
                'user' => new UserResource($this->whenLoaded('user')),
            ]
        );
    }
}
