<?php
use Illuminate\Support\Facades\Route;

Route::post('/token-whatsappweb', [App\Http\Controllers\AdminTokenWhatsAppWebController::class, 'index']);
Route::post('/token-whatsappweb/create', [App\Http\Controllers\AdminTokenWhatsAppWebController::class, 'store']);
Route::post('/token-whatsappweb/show', [App\Http\Controllers\AdminTokenWhatsAppWebController::class, 'show']);
Route::post('/token-whatsappweb/edit', [App\Http\Controllers\AdminTokenWhatsAppWebController::class, 'edit']);
Route::post('/token-whatsappweb/update', [App\Http\Controllers\AdminTokenWhatsAppWebController::class, 'update']);
Route::post('/token-whatsappweb/destroy', [App\Http\Controllers\AdminTokenWhatsAppWebController::class, 'destroy']);