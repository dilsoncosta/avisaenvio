<?php
use Illuminate\Support\Facades\Route;

Route::post('/config/import_contact', [App\Http\Controllers\ConfigImportController::class, 'index']);