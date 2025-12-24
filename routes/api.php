<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\CourseTypeController;
use App\Http\Controllers\Api\LeadController;
use App\Http\Controllers\Api\StaffController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/users', [UserController::class, 'index']);
});

/** ROLES */
Route::apiResource('roles', RoleController::class);

/** STAFF */
Route::apiResource('staffs', StaffController::class);
Route::put('staffs/{id}/toggle-status', [StaffController::class, 'toggleStatus']);

/** COURSES */
Route::apiResource('courses', CourseController::class);

/** COURSE TYPES */
Route::apiResource('course-types', CourseTypeController::class);

/** GET COURSE TYPES BY COURSE ID */
Route::get('courses/{id}/types', [CourseTypeController::class, 'getTypesByCourse']);

/** LEADS */
Route::apiResource('leads', LeadController::class);

Route::get('leads-new', [LeadController::class, 'newLeads']);
Route::get('leads-assigned', [LeadController::class, 'assignedLeads']);

Route::post('lead/add-timeline', [LeadController::class, 'addTimeline']);
Route::get('dashboard/leads', [LeadController::class, 'dashboard']);
