<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;



Route::get('/', [AuthenticatedSessionController::class, 'create']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
   
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

});

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');
    Route::post('/upload', [UserController::class, 'upload'])->name('upload');
    Route::get('/upload', [UserController::class, 'upload'])->name('user.upload');
    Route::middleware(['admin'])->group(function () {
        Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users');
        Route::post('/admin/review/{id}', [AdminController::class, 'review'])->name('admin.review');
        Route::get('/admin/usersDetails', [AdminController::class, 'users'])->name('admin.usersDetails');
        Route::get('/admin/usersDetails/edit/{id}', [AdminController::class, 'edit'])->name('admin.usersDetails.edit');
        Route::put('/admin/usersDetails/update/{id}', [AdminController::class, 'update'])->name('admin.usersDetails.update');
        Route::get('/admin/usersDetails/delete/{id}', [AdminController::class, 'delete'])->name('admin.usersDetails.delete');
        Route::get('/admin/usersDetails/show/{id}', [AdminController::class, 'show'])->name('admin.usersDetails.show');
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    });
});
 
