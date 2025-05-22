<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\TagApiController;
use App\Http\Controllers\Api\CommentApiController;
use App\Http\Controllers\Api\AboutApiController;
use App\Http\Controllers\Api\ContactApiController;
use App\Http\Controllers\Api\SearchApiController;

Route::prefix('about')->group(function () {
    Route::get('/', [AboutApiController::class, 'show']);
    Route::post('/update', [AboutApiController::class, 'update']);
    Route::post('/upload-image', [AboutApiController::class, 'uploadImage']);
});

// API nhận thông tin liên hệ
Route::post('/contacts', [ContactApiController::class, 'store']);

// API cho tìm kiếm
Route::get('/search', [SearchApiController::class, 'search'])->name('api.search');

// API cho lọc bài viết
Route::get('/filter', [SearchApiController::class, 'filter'])->name('api.filter');

// API cho danh mục (Category)
Route::apiResource('categories', CategoryApiController::class)->names('api.categories');

// API cho bài viết (Post)
Route::apiResource('posts', PostApiController::class);
Route::get('/posts/{post}/related', [PostApiController::class, 'related'])->name('api.posts.related');
Route::get('/categories/{categoryId}/posts', [PostApiController::class, 'postsByCategory'])->name('api.categories.posts');

// API cho thẻ (Tag)
Route::apiResource('tags', TagApiController::class);
Route::get('posts/{post}/tags', [PostApiController::class, 'tags'])->name('api.posts.tags');

// API cho bình luận (Comment)
Route::get('/comments', [CommentApiController::class, 'index'])->name('api.comments.index');
Route::get('/posts/{post}/comments', [CommentApiController::class, 'comments'])->name('api.comments.show');
Route::post('/posts/{post}/comments', [CommentApiController::class, 'store'])->name('api.comments.store');
Route::put('/posts/{post}/comments/{comment}', [CommentApiController::class, 'update'])->name('api.comments.update');
Route::delete('/posts/{post}/comments/{comment}', [CommentApiController::class, 'destroy'])->name('api.comments.destroy');
