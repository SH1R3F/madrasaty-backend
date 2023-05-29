<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Resources\PermissionResource;
use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\RegisterUserRequest;

class AuthController extends Controller
{
    /**
     * Register a new user
     */
    public function register(RegisterUserRequest $request)
    {
        $data = $request->validated();

        // Register a new user and assign default role
        $user = User::create($data);
        $user->syncRoles(Role::where('name', 'مدير الموقع')->first());

        return response()->json([
            'accessToken' => $user->createToken('auth')->plainTextToken,
            'userData' => new UserResource($user),
            'userAbilities' => PermissionResource::collection($user->getPermissionsViaRoles()),
        ]);
    }

    /**
     * Login user
     */
    public function login(LoginUserRequest $request)
    {
        $request->authenticate();
        $user = request()->user();

        return response()->json([
            'accessToken' => $user->createToken('auth')->plainTextToken,
            'userData' => new UserResource($user),
            'userAbilities' => PermissionResource::collection($user->getPermissionsViaRoles()),
        ]);
    }
}
