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

        Route::get('admin/classes', [ClassScheduleController::class, 'index']);
        Route::post('admin/classes', [ClassScheduleController::class, 'store']);
        Route::get('admin/classes/{class}', [ClassScheduleController::class, 'show']);
        Route::put('admin/classes/{class}', [ClassScheduleController::class, 'update']);
        Route::delete('admin/classes/{class}', [ClassScheduleController::class, 'destroy']);
    });

    Route::middleware(['role:trainer'])->group(function () {
        Route::get('trainer/classes', [TrainerController::class, 'index']);
    });

    Route::middleware(['role:trainee'])->group(function () {
        Route::get('trainee/profile', [TraineeController::class, 'profile']);
        Route::post('trainee/bookings', [BookingController::class, 'store']);
        Route::get('trainee/bookings', [BookingController::class, 'index']);
        Route::delete('trainee/bookings/{booking}', [BookingController::class, 'destroy']);
    });
});
