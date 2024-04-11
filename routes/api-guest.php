<?php
use Illuminate\Support\Facades\Route;

Route::post('/guest', [App\Http\Controllers\GuestController::class, 'index']);
Route::post('/guest/create', [App\Http\Controllers\GuestController::class, 'store']);
Route::post('/guest/show', [App\Http\Controllers\GuestController::class, 'show']);
Route::post('/guest/edit', [App\Http\Controllers\GuestController::class, 'edit']);
Route::post('/guest/update', [App\Http\Controllers\GuestController::class, 'update']);
Route::post('/guest/destroy', [App\Http\Controllers\GuestController::class, 'destroy']);