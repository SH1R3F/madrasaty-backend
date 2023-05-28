<?php

namespace App\Http\Controllers\Api;

use App\Models\Note;
use App\Models\Student;
use App\Models\Classroom;
use Illuminate\Http\Request;
use App\Http\Requests\NoteRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\NoteResource;
use App\Http\Resources\StudentResource;
use App\Http\Resources\ClassroomResource;

class NoteController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Note::class, 'note');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $students = Note::with('classroom', 'student', 'user')
            ->filter($request)
            ->search($request->q, ['name', 'points'])
            ->order($request->options['sortBy'] ?? [])
            ->paginate($request->options['itemsPerPage'] ?? 10, ['*'], 'page', $request->options['page'] ?? 1)
            ->withQueryString();

        return NoteResource::collection($students)->additional([
            'classrooms' => ClassroomResource::collection(Classroom::all()),
            'students'   => StudentResource::collection(Student::all()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NoteRequest $request)
    {
        $data = $request->validated();
        $note = $request->user()->notes()->create($data);

        return response()->json([
            'status'  => 'success',
            'message' => __('Note created successfully'),
            'user'    => new NoteResource($note)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        return new NoteResource($note);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NoteRequest $request, Note $note)
    {
        $data = $request->validated();
        $note->update($data);

        return response()->json([
            'status'  => 'success',
            'message' => __('Note updated successfully'),
            'user'    => new NoteResource($note)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        $note->delete();

        return response()->json([
            'status'  => 'success',
            'message' => __('Note deleted successfully')
        ]);
    }
}
