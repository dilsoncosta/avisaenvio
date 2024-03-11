<?php
use Illuminate\Support\Facades\Route;

Route::post('/genereateOptionsCollaborators', [App\Http\GenerateOptions\GenerateOptionsCollaborators::class, 'index']);
Route::post('/genereateOptionsTenants', [App\Http\GenerateOptions\GenerateOptionsTenants::class, 'index']);
Route::post('/generateOptionsIntegrationWhatsApp', [App\Http\GenerateOptions\GenerateOptionsIntegrationWhatsApp::class, 'index']);

