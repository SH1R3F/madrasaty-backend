<?php

namespace App\Http\Controllers\Api;

use App\Models\Classroom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClassroomRequest;
use App\Http\Resources\ClassroomResource;

class ClassroomController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Classroom::class, 'classroom');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $classrooms = Classroom::withCount('students')
            ->search($request->q, ['name'])
            ->order($request->options['sortBy'] ?? [])
            ->paginate($request->options['itemsPerPage'] ?? 10, ['*'], 'page', $request->options['page'] ?? 1)
            ->withQueryString();

        return ClassroomResource::collection($classrooms);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClassroomRequest $request)
    {
        $data = $request->validated();

        $classroom = Classroom::create($data);

        return response()->json([
            'status'    => 'success',
            'message'   => __('Classroom created successfully'),
            'classroom' => new ClassroomResource($classroom)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Classroom $classroom)
    {
        return new ClassroomResource($classroom->load('students'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(ClassroomRequest $request, Classroom $classroom)
    {
        $data = $request->validated();

        $classroom->update(['name' => $data['name']]);

        return response()->json([
            'status'    => 'success',
            'message'   => __('Classroom updated successfully'),
            'classroom' => new ClassroomResource($classroom)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classroom $classroom)
    {
        $classroom->delete();
        return response()->json([
            'status'    => 'success',
            'message'   => __('Classroom deleted successfully'),
        ]);
    }
}
