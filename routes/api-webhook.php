<?php
use Illuminate\Support\Facades\Route;

Route::post('/webhook/integration_form/{f_token?}/{e_token?}/{origin?}/{conversation?}', [App\Http\Webhook\IntegrationForm::class, 'index']);
Route::post('/webhook/api_whatsapp', [App\Http\Webhook\ApiWhatsApp::class, 'index']);
Route::post('/webhook/api_whatsapp/messages-upsert', [App\Http\Webhook\ApiWhatsApp::class, 'messages_upsert']);