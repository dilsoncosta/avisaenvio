<?php
use Illuminate\Support\Facades\Route;

Route::post('/logout', [App\Http\Controllers\Auth\AuthController::class, 'logout']);
Route::post('/profile', [App\Http\Controllers\Auth\ProfileController::class, 'update']);
Route::get('/me', [App\Http\Controllers\Auth\AuthController::class, 'me']);