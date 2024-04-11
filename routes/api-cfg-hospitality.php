<?php
use Illuminate\Support\Facades\Route;

Route::post('/config/hospitality', [App\Http\Controllers\HospitalityController::class, 'index']);
Route::post('/config/hospitality/update', [App\Http\Controllers\HospitalityController::class, 'update']);