<?php
use Illuminate\Support\Facades\Route;

Route::post('/order', [App\Http\Controllers\OrderController::class, 'index']);
Route::post('/order/create', [App\Http\Controllers\OrderController::class, 'store']);
Route::post('/order/show', [App\Http\Controllers\OrderController::class, 'show']);
Route::post('/order/edit', [App\Http\Controllers\OrderController::class, 'edit']);
Route::post('/order/update', [App\Http\Controllers\OrderController::class, 'update']);
Route::post('/order/destroy', [App\Http\Controllers\OrderController::class, 'destroy']);