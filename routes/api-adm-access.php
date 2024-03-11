<?php
use Illuminate\Support\Facades\Route;

Route::post('/access', [App\Http\Controllers\AdminAccessController::class, 'index']);
Route::post('/access/update', [App\Http\Controllers\AdminAccessController::class, 'update']);