<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Trainer\TrainerController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [AuthenticatedSessionController::class, 'create']);
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Admin routes
    Route::middleware(['admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users');
        Route::post('/admin/review/{id}', [AdminController::class, 'review'])->name('admin.review');
        Route::get('/admin/usersDetails', [AdminController::class, 'users'])->name('admin.usersDetails');
        Route::get('/admin/usersDetails/edit/{id}', [AdminController::class, 'edit'])->name('admin.usersDetails.edit');
        Route::put('/admin/usersDetails/update/{id}', [AdminController::class, 'update'])->name('admin.usersDetails.update');
        Route::get('/admin/usersDetails/delete/{id}', [AdminController::class, 'delete'])->name('admin.usersDetails.delete');
        Route::get('/admin/usersDetails/show/{id}', [AdminController::class, 'show'])->name('admin.usersDetails.show');
    });

    // Trainer routes
    Route::middleware(['trainer'])->group(function () {
        Route::get('/trainer/dashboard', [TrainerController::class, 'index'])->name('trainer.dashboard');
        Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users');
        Route::post('/admin/review/{id}', [AdminController::class, 'review'])->name('admin.review');
       
    });

    // Student routes
    Route::get('/student/dashboard', [UserController::class, 'index'])->name('student.dashboard');
    Route::post('/upload', [UserController::class, 'upload'])->name('upload');
    Route::get('/upload', [UserController::class, 'upload'])->name('user.upload');
});

require __DIR__.'/auth.php';