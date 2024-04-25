<?php
use Illuminate\Support\Facades\Route;

Route::post('/financial', [App\Http\Controllers\FinancialController::class, 'index']);
Route::post('/financial/charge', [App\Http\Controllers\FinancialController::class, 'getCharge']);
Route::post('/financial/createSignature', [App\Http\Controllers\FinancialController::class, 'storeSignature']);
Route::post('/financial/canceledSignature', [App\Http\Controllers\FinancialController::class, 'canceledSignature']);