<?php
use Illuminate\Support\Facades\Route;

Route::post('/report/franchise', [App\Http\Controllers\ReportFranchiseController::class, 'index']);