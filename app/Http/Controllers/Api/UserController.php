<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::filter($request)
            ->search($request->q, ['name', 'email'])
            ->order($request->options['sortBy'] ?? [])
            ->paginate($request->options['itemsPerPage'] ?? 10, ['*'], 'page', $request->options['page'] ?? 1)
            ->withQueryString();

        return UserResource::collection($users)->additional([
            'stats' => [
                'total'       => User::count(),
                'superadmins' => User::whereHas('roles', fn ($query) => $query->where('name', 'مدير الموقع'))->count(),
                'active'      => User::where('status', 1)->count(),
                'inactive'    => User::where('status', 0)->count(),
            ]
        ]);
    }

    /**
     * Export to excel.
     */
    public function export(Request $request)
    {
        $this->authorize('view', User::class);

        $users = User::filter($request)
            ->search($request->q, ['name', 'email'])
            ->order($request->options['sortBy'] ?? [])
            ->get();

        Excel::store(new UsersExport($users), $path = 'Exports/Users/Users-' . time() . '.xlsx', 'public');
        return response()->json([
            'status' => 'success',
            'url'    => Storage::url($path)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);

        $user->assignRole(Role::find($data['role_id']));

        return response()->json([
            'status'  => 'success',
            'message' => __('User created successfully'),
            'user'    => new UserResource($user)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $data = $request->validated();
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $user->update($data);

        $user->syncRoles($data['role_id']);

        return response()->json([
            'status'  => 'success',
            'message' => __('User updated successfully'),
            'user'    => new UserResource($user)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
            'status'  => 'success',
            'message' => __('User deleted successfully')
        ]);
    }
}
