<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:web'])->group(function() {
    // Route::apiResource('articles', ArticleController::class);

    Route::prefix('articles')->group(function() {
        Route::post('/', [ArticleController::class, 'store']);

        Route::prefix('/{article}')->group(function() {
            Route::put('/', [ArticleController::class, 'update'])->can('owns', Article::class);
            Route::delete('/', [ArticleController::class, 'destroy'])->can('owns', Article::class);
        });
    });
        
    Route::prefix('comments')->group(function() {
        Route::post('/', [CommentController::class, 'store']);

        Route::prefix('/{comment}')->group(function() {
            Route::put('/', [CommentController::class, 'update'])->can('owns', Comment::class);
            Route::delete('/', [CommentController::class, 'destroy'])->can('owns', Comment::class);
        });
    });

    Route::get('user', function() {
        return Auth::user();
    });
});

Route::prefix('articles')->group(function() {
    Route::get('/', [ArticleController::class, 'index']);
    Route::get('/{article}', [ArticleController::class, 'show']);
});