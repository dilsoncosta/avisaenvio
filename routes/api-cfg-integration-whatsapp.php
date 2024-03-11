<?php
use Illuminate\Support\Facades\Route;

Route::post('/integration_whatsapp/disabled', [App\Http\Controllers\IntegrationWhatsAppController::class, 'disabledIntegration']);
Route::post('/integration_whatsapp/active', [App\Http\Controllers\IntegrationWhatsAppController::class, 'activeIntegration']);
Route::post('/integration_whatsapp/getStatusIntegrationWhatsApp', [App\Http\Controllers\IntegrationWhatsAppController::class, 'getStatusIntegrationWhatsApp']);
Route::post('/integration_whatsapp/getAllChatWithMessage', [App\Http\Controllers\IntegrationWhatsAppController::class, 'getAllChatWithMessage']);