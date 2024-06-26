<?php
use Illuminate\Support\Facades\Route;

Route::post('/integration_tray/disabled', [App\Http\Controllers\IntegrationTrayController::class, 'disabledIntegration']);
Route::post('/integration_tray/active', [App\Http\Controllers\IntegrationTrayController::class, 'activeIntegration']);
Route::post('/integration_tray/activeAutentication', [App\Http\Controllers\IntegrationTrayController::class, 'activeAutentication']);
Route::post('/integration_tray/getStatusIntegrationTray', [App\Http\Controllers\IntegrationTrayController::class, 'getStatusIntegrationTray']);