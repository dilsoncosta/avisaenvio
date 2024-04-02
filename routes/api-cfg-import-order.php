<?php
use Illuminate\Support\Facades\Route;

Route::post('/config/import_order', [App\Http\Controllers\ImportOrderController::class, 'index']);