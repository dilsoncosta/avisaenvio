<?php
use Illuminate\Support\Facades\Route;

Route::post('/auth', [App\Http\Controllers\Auth\AuthController::class, 'auth']);
Route::post('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLink']);
Route::post('/reset-password', [App\Http\Controllers\Auth\ResetPasswordController::class, 'resetPassword']);
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'store']);
Route::post('/confirmed-register', [App\Http\Controllers\Auth\RegisterController::class, 'confirmedRegister']);
Route::post('/checkSubdomain', [App\Http\Controllers\TenantController::class, 'getSubdomain']);