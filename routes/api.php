<?php

use App\Http\Controllers\Admin\ClassScheduleController;
use App\Http\Controllers\Admin\TrainerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\TraineeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:api'])->group(function () {
    Route::middleware(['role:admin'])->group(function () {

        Route::get('admin/trainers', [TrainerController::class, 'index']);
        Route::post('admin/trainers', [TrainerController::class, 'store']);
        Route::get('admin/trainers/{trainer}', [TrainerController::class, 'show']);
        Route::put('admin/trainers/{trainer}', [TrainerController::class, 'update']);
        Route::delete('admin/trainers/{trainer}', [TrainerController::class, 'destroy']);

        Route::get('admin/classes/get', [ClassScheduleController::class, 'index']);
        Route::post('admin/classes/store', [ClassScheduleController::class, 'store']);
        Route::get('admin/classes/{class}', [ClassScheduleController::class, 'show']);
        Route::put('admin/classes/{class}', [ClassScheduleController::class, 'update']);
        Route::delete('admin/classes/{class}', [ClassScheduleController::class, 'destroy']);
    });

    Route::middleware(['role:trainer'])->group(function () {
        Route::get('trainer/classes', [ClassScheduleController::class, 'index2']);
    });

    Route::middleware(['role:trainee'])->group(function () {
        Route::get('trainee/profile', [TraineeController::class, 'profile']);
        Route::post('trainee/profile/update', [TraineeController::class, 'updateProfile']);
        Route::post('trainee/bookings-store', [BookingController::class, 'store']);
        Route::get('trainee/bookings', [BookingController::class, 'index']);
        Route::delete('trainee/bookings/delete', [BookingController::class, 'destroy']);
        Route::get('trainee/avilableclass', [BookingController::class, 'availableClasses']);
    });
});
