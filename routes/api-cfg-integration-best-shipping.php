<?php
use Illuminate\Support\Facades\Route;

Route::post('/integration_best_shipping/disabled', [App\Http\Controllers\IntegrationBestShippingController::class, 'disabledIntegration']);
Route::post('/integration_best_shipping/active', [App\Http\Controllers\IntegrationBestShippingController::class, 'activeIntegration']);
Route::post('/integration_best_shipping/getStatusIntegrationBestShipping', [App\Http\Controllers\IntegrationBestShippingController::class, 'getStatusIntegrationBestShipping']);