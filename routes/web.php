<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Middleware\RedirectIfAdmin;
use App\Http\Middleware\RedirectIfNotAuthAdmin;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\InteractionController;
use App\Http\Controllers\RecommendationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [ArticleController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/articles/{article}/view', [InteractionController::class, 'view'])->name('articles.view');
    Route::get('/recommendations', [RecommendationController::class, 'index'])->name('recommendations.index');
});


// Admin Authentication Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])
        ->middleware(RedirectIfNotAuthAdmin::class)
        ->name('admin.login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');
    
    // Admin Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware(RedirectIfAdmin::class)
        ->name('admin.dashboard');
    
    // Admin Article Management
    Route::middleware(RedirectIfAdmin::class)->group(function () {
        // Article Routes
        Route::get('/articles', [AdminArticleController::class, 'index'])->name('admin.articles.index');
        Route::get('/articles/create', [AdminArticleController::class, 'create'])->name('admin.articles.create');
        Route::post('/articles', [AdminArticleController::class, 'store'])->name('admin.articles.store');
        Route::get('/articles/{article}/edit', [AdminArticleController::class, 'edit'])->name('admin.articles.edit');
        Route::put('/articles/{article}', [AdminArticleController::class, 'update'])->name('admin.articles.update');
        Route::delete('/articles/{article}', [AdminArticleController::class, 'destroy'])->name('admin.articles.destroy');
        
        // Category Routes
        Route::get('/categories', [AdminCategoryController::class, 'index'])->name('admin.categories.index');
        Route::get('/categories/create', [AdminCategoryController::class, 'create'])->name('admin.categories.create');
        Route::post('/categories', [AdminCategoryController::class, 'store'])->name('admin.categories.store');
        Route::get('/categories/{category}/edit', [AdminCategoryController::class, 'edit'])->name('admin.categories.edit');
        Route::put('/categories/{category}', [AdminCategoryController::class, 'update'])->name('admin.categories.update');
        Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('admin.categories.destroy');
    });
});

Route::get('/articles/{article}', [App\Http\Controllers\ArticleController::class, 'show'])->name('articles.show');

Route::post('/articles/{article}/like', [InteractionController::class, 'toggleLike'])
    ->middleware(['auth'])
    ->name('articles.like');

require __DIR__ . '/auth.php';
