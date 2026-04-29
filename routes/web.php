<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Author\PostController as AuthorPostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Moderator\PostController as ModeratorPostController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::get('/categories/{category}', [PostController::class, 'category'])->name('categories.show');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/comments/{comment}/reply', [CommentController::class, 'reply'])->name('comments.reply');

    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    Route::middleware(['can:access-author'])->prefix('author')->name('author.')->group(function () {

        Route::resource('/posts', AuthorPostController::class);

        Route::patch('/posts/{post}/submit', [AuthorPostController::class, 'submit'])->name('posts.submit');
    });

    Route::middleware(['can:access-moderator'])->prefix('moderator')->name('moderator.')->group(function () {

        Route::get('/pending', [ModeratorPostController::class, 'index'])->name('posts.index');

        Route::patch('/posts/{post}/approve', [ModeratorPostController::class, 'approve'])->name('posts.approve');

        Route::get('/posts/{post}/reject', [ModeratorPostController::class, 'rejectForm'])->name('posts.reject.form');
        Route::patch('/posts/{post}/reject', [ModeratorPostController::class, 'reject'])->name('posts.reject');
    });

    Route::middleware(['can:access-admin'])->prefix('admin')->name('admin.')->group(function () {

        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.updateRole');

        Route::patch('/users/{user}/toggleban', [UserController::class, 'toggleBan'])->name('users.toggleban');
    });
});

require __DIR__.'/auth.php';
