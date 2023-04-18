<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\api\users\usersController;
use App\Http\Controllers\api\projects\projectsController;

use App\Http\Controllers\api\tasks\tasksController;

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


Route::post('/register', [AuthController::class, 'sign_up']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('users', usersController::class);
    Route::apiResource('projects', projectsController::class);
    Route::post('singleproject/{id}', [projectsController::class, 'getSingleProject']);

    Route::apiResource('tasks', tasksController::class);
    Route::post('singletask/{id}', [tasksController::class, 'getSingletask']);
    Route::post('tasksFilter', [tasksController::class, 'filter']);
    Route::post('deletefile/{id}', [tasksController::class, 'deletefile']);
    Route::post('addcommenttask/{taskId}', [tasksController::class, 'addcommenttask']);
    Route::post('deleteComment/{id}', [tasksController::class, 'deleteComment']);

    Route::get('user', function (Request $request) {
        // return $request->user();
        return response()->json($request->user(),200);
    });
    
});