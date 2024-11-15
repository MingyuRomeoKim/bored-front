<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;


Route::get('/', [MainController::class, 'index']);
Route::get('/write',[MainController::class, 'write']);

Route::post('signUp', [AuthController::class, 'signUp'])->name('signUp');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');