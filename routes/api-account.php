<?php
use Illuminate\Support\Facades\Route;

Route::post('/account', [App\Http\Controllers\AccountController::class, 'index']);
Route::post('/account/update', [App\Http\Controllers\AccountController::class, 'update']);
Route::post('/account/destroyCertificate', [App\Http\Controllers\AccountController::class, 'destroyCertificate']);