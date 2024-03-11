<?php
use Illuminate\Support\Facades\Route;

Route::get('/dashboard/totalfrachises', [App\Http\Controllers\HomeController::class, 'getTotalfrachises']);
Route::get('/dashboard/totalCollaborators', [App\Http\Controllers\HomeController::class, 'getTotalCollaborators']);
Route::get('/dashboard/totalWorkflows', [App\Http\Controllers\HomeController::class, 'getTotalWorkflows']);