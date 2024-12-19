<?php

use App\Http\Controllers\ArticleController;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:web'])->group(function() {
    // Route::apiResource('articles', ArticleController::class);

    Route::prefix('articles')->group(function() {
        Route::post('/', [ArticleController::class, 'store']);

        Route::prefix('/{article}')->can('owns', Article::class)->group(function() {
            Route::put('/', [ArticleController::class, 'update']);
            Route::delete('/', [ArticleController::class, 'destroy']);
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