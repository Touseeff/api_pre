<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\apiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/user/login', [apiController::class, 'authLogin'])->name('user.login');
Route::post('/user/store', [apiController::class, 'store'])->name('user.store');

Route::middleware('auth:sanctum')->group(function () {


    Route::get('/user/show/{id}', [apiController::class, 'show'])->name('user.show');

    Route::post('/user/forgot-password', [apiController::class, 'forgotPassword'])->name('user.forgot.password');
});

