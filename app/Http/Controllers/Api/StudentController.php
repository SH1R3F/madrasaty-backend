<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use App\Models\Classroom;
use Illuminate\Http\Request;
use App\Exports\StudentsExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StudentRequest;
use App\Http\Resources\StudentResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ClassroomResource;

class StudentController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Student::class, 'student');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $students = Student::with('classroom')
            ->filter($request)
            ->search($request->q, ['name'])
            ->order($request->options['sortBy'] ?? [])
            ->paginate($request->options['itemsPerPage'] ?? 10, ['*'], 'page', $request->options['page'] ?? 1)
            ->withQueryString();

        return StudentResource::collection($students)->additional([
            'classrooms' => ClassroomResource::collection(Classroom::all())
        ]);
    }

    /**
     * Export to excel.
     */
    public function export(Request $request)
    {
        $this->authorize('view', Student::class);

        $users = Student::filter($request)
            ->search($request->q, ['name'])
            ->order($request->options['sortBy'] ?? [])
            ->get();

        Excel::store(new StudentsExport($users), $path = 'Exports/Students/Students-' . time() . '.xlsx', 'public');
        return response()->json([
            'status' => 'success',
            'url'    => Storage::url($path)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentRequest $request)
    {
        $data = $request->Validated();
        $student = Student::create($data);

        return response()->json([
            'status'    => 'success',
            'message'   => __('Student created successfully'),
            'classroom' => new StudentResource($student)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        return new StudentResource($student);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StudentRequest $request, Student $student)
    {
        $data = $request->Validated();
        $student->update($data);

        return response()->json([
            'status'    => 'success',
            'message'   => __('Student updated successfully'),
            'classroom' => new StudentResource($student)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $points = $student->notes()->sum('points');
        $student->classroom()->update(['points' => $student->classroom->points - $points]);
        $student->delete();

        return response()->json([
            'status'    => 'success',
            'message'   => __('Student deleted successfully'),
        ]);
    }
}
