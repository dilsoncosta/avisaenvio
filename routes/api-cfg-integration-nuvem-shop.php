<?php
use Illuminate\Support\Facades\Route;

Route::post('/integration_nuvem_shop/disabled', [App\Http\Controllers\IntegrationNuvemShopController::class, 'disabledIntegration']);
Route::post('/integration_nuvem_shop/active', [App\Http\Controllers\IntegrationNuvemShopController::class, 'activeIntegration']);
Route::post('/integration_nuvem_shop/getStatusIntegrationNuvemShop', [App\Http\Controllers\IntegrationNuvemShopController::class, 'getStatusIntegrationNuvemShop']);