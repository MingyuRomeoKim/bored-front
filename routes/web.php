<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegionController;


Route::get('/', [MainController::class, 'index']);
Route::get('/write',[MainController::class, 'write']);
Route::post('/write',[MainController::class, 'save']);
Route::get('/article/{articleId}',[MainController::class, 'show']);

Route::prefix('region')->group(function (){
    Route::get('/{regionTitleEn}', [RegionController::class, 'index']);
    Route::get('/{regionTitleEn}/theme/{themeTitleEn}', [RegionController::class, 'index']);
});

Route::post('signUp', [AuthController::class, 'signUp'])->name('signUp');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');