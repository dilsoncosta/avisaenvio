<?php
use Illuminate\Support\Facades\Route;

Route::post('/dashboard', [App\Http\Controllers\HomeController::class, 'index']);