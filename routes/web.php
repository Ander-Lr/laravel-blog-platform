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
// Protected routes, only admin
Route::middleware(['role:admin'])->prefix('admin')->group(function () {

    // List users
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');

    // Create user form
    Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');

    // Store new user
    Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');

    // Show user detail
    Route::get('/users/{user}', [UserController::class, 'show'])->name('admin.users.show');

    // Edit form
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');

    // Update user
    Route::put('/users/{user}', [UserController::class, 'update'])->name('admin.users.update');

    // Delete user
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
});


// Protected routes, only admin/editor can manage comments
Route::middleware(['role:editor,admin'])
    ->prefix('admin')
    ->group(function () {

    // List all comments
    Route::get('/comments', [CommentController::class, 'index'])
        ->name('admin.comments.index');

    // Show comment detail
    Route::get('/comments/{comment}', [CommentController::class, 'show'])
        ->name('admin.comments.show');

    // Edit comment form
    Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])
        ->name('admin.comments.edit');

    // Update comment
    Route::put('/comments/{comment}', [CommentController::class, 'update'])
        ->name('admin.comments.update');

    // Delete comment
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])
        ->name('admin.comments.destroy');
});



//Authentication routes
require __DIR__.'/auth.php';