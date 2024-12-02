<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\CommentController;

Route::get('/', [MainController::class, 'index']);

Route::prefix('region')->group(function (){
    Route::get('/{regionTitleEn}', [RegionController::class, 'index'])->name('region.index');
    Route::get('/{regionTitleEn}/theme/{themeTitleEn}', [RegionController::class, 'index'])->name('region.theme.index');
    Route::get('/{regionTitleEn}/theme/{themeTitleEn}/write',[RegionController::class, 'write']);
    Route::post('/{regionTitleEn}/theme/{themeTitleEn}/write',[RegionController::class, 'save']);
    Route::get('/{regionTitleEn}/theme/{themeTitleEn}/post/{postId}',[RegionController::class, 'show']);
});

Route::prefix('comment')->group(function (){
    Route::post("/{postId}", [CommentController::class, 'save']);
});

Route::post('signUp', [AuthController::class, 'signUp'])->name('signUp');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');