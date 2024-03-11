<?php
use Illuminate\Support\Facades\Route;

Route::post('/permission', [App\Http\Controllers\AdminPermissionController::class, 'index']);
Route::post('/permission/create', [App\Http\Controllers\AdminPermissionController::class, 'store']);
Route::post('/permission/show', [App\Http\Controllers\AdminPermissionController::class, 'show']);
Route::post('/permission/edit', [App\Http\Controllers\AdminPermissionController::class, 'edit']);
Route::post('/permission/update', [App\Http\Controllers\AdminPermissionController::class, 'update']);
Route::post('/permission/destroy', [App\Http\Controllers\AdminPermissionController::class, 'destroy']);