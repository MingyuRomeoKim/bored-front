<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegionController;


Route::get('/', [MainController::class, 'index']);
Route::get('/article/{articleId}',[MainController::class, 'show']);

Route::prefix('region')->group(function (){
    Route::get('/{regionTitleEn}', [RegionController::class, 'index'])->name('region.index');
    Route::get('/{regionTitleEn}/theme/{themeTitleEn}', [RegionController::class, 'index'])->name('region.theme.index');
    Route::get('/{regionTitleEn}/theme/{themeTitleEn}/write',[RegionController::class, 'write']);
    Route::post('/{regionTitleEn}/theme/{themeTitleEn}/write',[RegionController::class, 'save']);
});

Route::post('signUp', [AuthController::class, 'signUp'])->name('signUp');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');