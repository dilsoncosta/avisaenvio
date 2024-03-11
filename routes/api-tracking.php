<?php
use Illuminate\Support\Facades\Route;

Route::post('/tracking', [App\Http\Controllers\TrackingController::class, 'index']);
Route::post('/tracking/create', [App\Http\Controllers\TrackingController::class, 'store']);
Route::post('/tracking/show', [App\Http\Controllers\TrackingController::class, 'show']);
Route::post('/tracking/edit', [App\Http\Controllers\TrackingController::class, 'edit']);
Route::post('/tracking/update', [App\Http\Controllers\TrackingController::class, 'update']);
Route::post('/tracking/destroy', [App\Http\Controllers\TrackingController::class, 'destroy']);