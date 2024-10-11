<?php


use App\Http\Controllers\Frontend\ABookingController;
use App\Http\Controllers\Frontend\AClassScheduleController;
use App\Http\Controllers\Frontend\ATraineeController;
use App\Http\Controllers\Frontend\ATrainerController;
use App\Http\Controllers\Frontend\BookingController;
use App\Http\Controllers\Frontend\TraineeController;
use App\Http\Controllers\Frontend\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('frontend.login');
});
Route::get('/trainer', function () {
    return view('auth.trainer_login');
});
Route::get('/trainee', function () {
    return view('auth.trainee_login');
});

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/'); 
})->name('logout');

Route::get('/dashboard', function () {
    return view('frontend.dashboard');
})->middleware('auth');



// Profile routes (protected by auth middleware)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes - Requires 'admin' role
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Trainer Management
    Route::get('admin/trainers', [ATrainerController::class, 'index'])->name('admin.trainers.index');
    Route::get('admin/trainers/create', [ATrainerController::class, 'create'])->name('admin.trainers.create');
    Route::post('admin/trainers', [ATrainerController::class, 'store'])->name('admin.trainers.store');
    Route::get('admin/trainers/{trainer}', [ATrainerController::class, 'show'])->name('admin.trainers.show');
    Route::get('admin/trainers/{trainer}/edit', [ATrainerController::class, 'edit'])->name('admin.trainers.edit');
    Route::put('admin/trainers/{trainer}', [ATrainerController::class, 'update'])->name('admin.trainers.update');
    Route::delete('admin/trainers/{trainer}', [ATrainerController::class, 'destroy'])->name('admin.trainers.destroy');

    // Class Schedule Management
    Route::get('admin/classes', [AClassScheduleController::class, 'index'])->name('admin.classes.index');
    Route::get('admin/classes/create', [AClassScheduleController::class, 'create'])->name('admin.classes.create');
    Route::post('admin/classes', [AClassScheduleController::class, 'store'])->name('admin.classes.store');
    Route::get('admin/classes/{class}', [AClassScheduleController::class, 'show'])->name('admin.classes.show');
    Route::get('admin/classes/{class}/edit', [AClassScheduleController::class, 'edit'])->name('admin.classes.edit');
    Route::put('admin/classes/{class}', [AClassScheduleController::class, 'update'])->name('admin.classes.update');
    Route::delete('admin/classes/{class}', [AClassScheduleController::class, 'destroy'])->name('admin.classes.destroy');
});

Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::get('trainer/classes', [ATraineeController::class, 'index'])->name('trainer.classes.index');
});

// Trainee Routes - Requires 'trainee' role
Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::get('trainee/profile', [ATraineeController::class, 'profile'])->name('trainee.profile');
    Route::post('trainee/profile/update', [ATraineeController::class, 'updateProfile'])->name('trainee.profile.update');

    // Bookings
    Route::post('trainee/bookings/store', [ABookingController::class, 'store'])->name('trainee.bookings.store');
    Route::get('trainee/bookings', [ABookingController::class, 'index'])->name('trainee.bookings.index');
    Route::delete('trainee/bookings/{booking}', [ABookingController::class, 'destroy'])->name('trainee.bookings.destroy');

    // Available classes
    Route::get('trainee/available-classes', [ABookingController::class, 'availableClasses'])->name('trainee.available.classes');
});

// Import additional auth routes
require __DIR__ . '/auth.php';
