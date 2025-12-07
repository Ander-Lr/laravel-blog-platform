<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Admin\UserController;


Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');

Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

// home
Route::get('/home', function () {
    return view('home');
})->middleware(['auth'])->name('home.dashboard');    

// blog main page
Route::get('/posts', [PostController::class, 'home'])->name('posts.index');
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

Route::middleware(['role:admin'])->group(function () {

    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');

    Route::get('/admin/users/{user}', [UserController::class, 'show'])->name('admin.users.show');

    Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');

    Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
});

//Authentication routes
require __DIR__.'/auth.php';