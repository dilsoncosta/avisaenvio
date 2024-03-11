<?php
use Illuminate\Support\Facades\Route;

Route::post('/collaborator', [App\Http\Controllers\CollaboratorController::class, 'index']);
Route::post('/collaborator/resources', [App\Http\Controllers\CollaboratorController::class, 'getAllResources']);
Route::post('/collaborator/create', [App\Http\Controllers\CollaboratorController::class, 'store']);
Route::post('/collaborator/show', [App\Http\Controllers\CollaboratorController::class, 'show']);
Route::post('/collaborator/edit', [App\Http\Controllers\CollaboratorController::class, 'edit']);
Route::post('/collaborator/update', [App\Http\Controllers\CollaboratorController::class, 'update']);
Route::post('/collaborator/destroy', [App\Http\Controllers\CollaboratorController::class, 'destroy']);