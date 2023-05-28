<?php

namespace App\Services;

use App\Models\Note;
use App\Models\Student;


class NoteService
{
    /**
     * Store new note & update its classroom points
     */
    public function store($user, array $data): Note
    {
        if (empty($data['classroom_id'])) {
            $data['classroom_id'] = Student::find($data['student_id'])->classroom_id;
        }
        $note = $user->notes()->create($data);

        $note->classroom()->update(['points' => $note->classroom->points + $data['points']]);

        return $note;
    }
}
