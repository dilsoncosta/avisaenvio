<?php
use Illuminate\Support\Facades\Route;

Route::post('/template', [App\Http\Controllers\TemplateController::class, 'index']);
Route::post('/template/create', [App\Http\Controllers\TemplateController::class, 'store']);
Route::post('/template/sendModelWhatsApp', [App\Http\Controllers\TemplateController::class, 'sendModelWhatsApp']);
Route::post('/template/show', [App\Http\Controllers\TemplateController::class, 'show']);
Route::post('/template/edit', [App\Http\Controllers\TemplateController::class, 'edit']);
Route::post('/template/update', [App\Http\Controllers\TemplateController::class, 'update']);
Route::post('/template/destroy', [App\Http\Controllers\TemplateController::class, 'destroy']);
Route::post('/template/destroyFile', [App\Http\Controllers\TemplateController::class, 'destroyFile']);