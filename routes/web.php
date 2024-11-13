<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\BoardController;

Route::get('/', [MainController::class, 'index']);

Route::prefix('board')->group(function () {
    Route::get('list', [BoardController::class, 'list']);
    Route::get('/{id}', [BoardController::class, 'show']);
    Route::get('write', [BoardController::class, 'write']);
});
