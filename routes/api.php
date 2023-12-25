<?php

use App\Http\Controllers\V1\AdminController;
use App\Http\Controllers\V1\AttendanceController;
use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\ClassroomController;
use App\Http\Controllers\V1\ConfigController;
use App\Http\Controllers\V1\PasswordController;
use App\Http\Controllers\V1\ProfileController;
use App\Http\Controllers\V1\ScheduleController;
use App\Http\Controllers\V1\StudentController;
use App\Http\Controllers\V1\SubjectController;
use App\Http\Controllers\V1\TeacherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/test', function (Request $request) {
    return $request->user();
});

Route::prefix('/v1')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/change-password', [PasswordController::class, 'changePassword']);
        Route::post('/change-profile-picture', [ProfileController::class, 'updateProfilePicture']);

        Route::middleware('abilities:admin,teacher')->group(function () {
            Route::get('/attendances/today', [AttendanceController::class, 'todayAttendance']);
            Route::get('/attendances/{student}/recap', [AttendanceController::class, 'studentRecap']);
            Route::put('/attendances/{attendance}', [AttendanceController::class, 'updateAttendance']);
        });

        Route::middleware('abilities:admin')->group(function () {
            Route::apiResource('/subjects', SubjectController::class);
            Route::apiResource('/teachers', TeacherController::class);
            Route::apiResource('/admins', AdminController::class);
            Route::apiResource('/students', StudentController::class);
            Route::apiResource('/classrooms', ClassroomController::class);
            Route::apiResource('/schedules', ScheduleController::class);
            Route::apiResource('/configs', ConfigController::class)->only('index', 'update');
        });

        Route::middleware('abilities:teacher')->group(function () {
            Route::get('/my-schedules', [ScheduleController::class, 'mySchedule']);
        });

        Route::middleware('abilities:student')->group(function () {
            Route::post('/attendance-in', [AttendanceController::class, 'attendanceIn']);
        });
    });

    Route::post('/admin/login', [AuthController::class, 'loginAdmin']);
    Route::post('/teacher/login', [AuthController::class, 'loginTeacher']);
    Route::post('/student/login', [AuthController::class, 'loginStudent']);
});
