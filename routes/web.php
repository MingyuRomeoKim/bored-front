<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\AuthController;


Route::get('/', [MainController::class, 'index']);

Route::prefix('board')->group(function () {
    Route::get('list', [BoardController::class, 'list']);
    Route::get('/{id}', [BoardController::class, 'show']);
    Route::get('write', [BoardController::class, 'write']);
});

Route::post('signUp', [AuthController::class, 'signUp'])->name('signUp');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');