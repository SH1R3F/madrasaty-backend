<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\ClassroomController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/**
 * Localization
 */
Route::get('localization', [ApiController::class, 'localization']);

/**
 * Authentication routes
 */
Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});


/**
 * Must be authenticated routes
 */
Route::middleware('auth:sanctum')->group(function () {
    /**
     * Roles endpoints
     */
    Route::resource('roles', RoleController::class)->except(['edit', 'create']);

    /**
     * Users endpoints
     */
    Route::get('users/export', [UserController::class, 'export']);
    Route::resource('users', UserController::class)->except(['edit', 'create']);

    /**
     * Classrooms endpoints
     */
    Route::resource('classrooms', ClassroomController::class)->except(['edit', 'create']);

    /**
     * Students endpoints
     */
    Route::get('students/export', [StudentController::class, 'export']);
    Route::resource('students', StudentController::class)->except(['edit', 'create']);
});
