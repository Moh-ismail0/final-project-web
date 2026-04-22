<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminAuthController;

Route::get('/', function () {
    return view('welcome');
})->name('home-login');

// User Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Auth Routes
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::get('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Protected Routes - Users & Admins
Route::middleware(['auth.any'])->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [TaskController::class, 'dashboard'])->name('dashboard');
        Route::get('tasks/trashed', [TaskController::class, 'trashed'])->name('tasks.trashed');
        Route::post('tasks/{id}/restore', [TaskController::class, 'restore'])->name('tasks.restore');
        Route::delete('tasks/{id}/force-delete', [TaskController::class, 'forceDelete'])->name('tasks.forceDelete');
        Route::delete('tasks/destroy-all', [TaskController::class, 'destroyAll'])->name('tasks.destroyAll');
        Route::post('tasks/restore-all', [TaskController::class, 'restoreAll'])->name('tasks.restoreAll');
        Route::delete('tasks/force-delete-all', [TaskController::class, 'forceDeleteAll'])->name('tasks.forceDeleteAll');
        Route::post('tasks/{id}/comments', [CommentController::class, 'storeForTask'])->name('tasks.comments.store');
        Route::post('categories/{id}/comments', [CommentController::class, 'storeForCategory'])->name('categories.comments.store');
        Route::delete('comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');
        Route::post('tasks_update/{id}', [TaskController::class, 'update'])->name('tasks.update');
        Route::post('tasks/{id}/toggle-status', [TaskController::class, 'toggleStatus'])->name('tasks.toggleStatus');
        Route::post('tasks/{task}/toggle-star', [TaskController::class, 'toggleStar'])->name('tasks.toggleStar');
        Route::resource('tasks', TaskController::class);
        Route::resource('categories', CategoryController::class);
    });
});

// Protected Routes - Admins Only
Route::middleware(['auth:admin'])->prefix('dashboard')->group(function () {
    Route::get('admins', [AdminController::class, 'index'])->name('admins.index');
    Route::post('admins', [AdminController::class, 'store'])->name('admins.store');
    Route::delete('admins/{admin}', [AdminController::class, 'destroy'])->name('admins.destroy');
});
