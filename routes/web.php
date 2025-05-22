<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;

Route::get('/reset-password/{token}', function (string $token) {
    return view('login.password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', function () {
    return view('login.register');
})->name('register');

Route::middleware(['auth'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('container');

    Route::resource('users', UserController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('tags', TagController::class);
    Route::resource('posts', PostController::class);
    Route::post('/posts/upload-image', [PostController::class, 'uploadImage'])->name('posts.upload-image');

    // Routes cho quản lý comment
    Route::get('comments', [CommentController::class, 'index'])->name('comments.index');
    Route::get('comments/post/{post}', [CommentController::class, 'showComments'])->name('comments.show');
    Route::post('comments/post/{post}', [CommentController::class, 'store'])->name('comments.store');
    Route::get('comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::put('comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');


    Route::get('/about', [AboutController::class, 'index'])->name('about.index');
    Route::get('/about/create', [AboutController::class, 'create'])->name('about.create');
    Route::post('/about', [AboutController::class, 'store'])->name('about.store');
    Route::get('/about/{about}/edit', [AboutController::class, 'edit'])->name('about.edit');
    Route::put('/about/{about}', [AboutController::class, 'update'])->name('about.update');
    Route::delete('/about/{about}', [AboutController::class, 'destroy'])->name('about.destroy');
    Route::post('/about/upload-image', [AboutController::class, 'uploadImage'])->name('about.upload-image');

    Route::get('/contacts', [ContactController::class, 'index']);
    Route::get('/contacts/{id}', [ContactController::class, 'show']);
    Route::post('/contacts', [ContactController::class, 'store']);
});
