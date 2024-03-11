<?php
use Illuminate\Support\Facades\Route;

Route::post('/resource', [App\Http\Controllers\AdminResourceController::class, 'index']);
Route::post('/resource/create', [App\Http\Controllers\AdminResourceController::class, 'store']);
Route::post('/resource/show', [App\Http\Controllers\AdminResourceController::class, 'show']);
Route::post('/resource/edit', [App\Http\Controllers\AdminResourceController::class, 'edit']);
Route::post('/resource/update', [App\Http\Controllers\AdminResourceController::class, 'update']);
Route::post('/resource/destroy', [App\Http\Controllers\AdminResourceController::class, 'destroy']);