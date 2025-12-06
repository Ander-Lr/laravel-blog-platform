<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Admin\UserController;

// blog main page
Route::get('/', [PostController::class, 'index'])->name('home');
// detail of a post
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
// Public comments
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
//Protected routes, login required, only editor and admin
Route::middleware(['role:editor,admin'])->group(function () {
    // CRUD post
    Route::resource('posts', PostController::class)->except(['index', 'show']);
});
// Protected routes, login required, only admin
Route::middleware(['role:admin'])->group(function () {
    // view user list
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    // Edit user role 
    Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    // Update role
    Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
});
//Authentication routes
require __DIR__.'/auth.php';