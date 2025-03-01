<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Middleware\RedirectIfAdmin;
use App\Http\Middleware\RedirectIfNotAuthAdmin;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Admin Authentication Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])
        ->middleware(RedirectIfNotAuthAdmin::class)
        ->name('admin.login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(RedirectIfAdmin::class)->name('admin.dashboard');
});



require __DIR__ . '/auth.php';
