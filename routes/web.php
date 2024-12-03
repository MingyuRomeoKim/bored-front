<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\PostController;

Route::get('/', [MainController::class, 'index']);

Route::prefix('region')->group(function (){
    Route::get('/{regionId}', [RegionController::class, 'index'])->name('region.index');
});

Route::prefix('theme')->group(function (){
    Route::get('/{themeId}', [ThemeController::class, 'index'])->name('theme.index');
    Route::get('/{themeId}/write',[ThemeController::class, 'write']);
    Route::post('/{themeId}/write',[ThemeController::class, 'save']);
});

Route::prefix('post')->group(function (){
    Route::get('/{postId}',[PostController::class, 'show']);
});

Route::prefix('comment')->group(function (){
    Route::post("/{postId}", [CommentController::class, 'save']);
});

Route::prefix('notice')->group(function (){
    Route::get('/policy', [MainController::class, 'policy']);
});

Route::get('/auth/confirm',[AuthController::class, 'confirm']);

Route::post('signUp', [AuthController::class, 'signUp'])->name('signUp');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');