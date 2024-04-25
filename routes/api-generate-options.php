<?php
use Illuminate\Support\Facades\Route;

Route::post('/genereateOptionsCollaborators', [App\Http\GenerateOptions\GenerateOptionsCollaborators::class, 'index']);
Route::post('/genereateOptionsTenants', [App\Http\GenerateOptions\GenerateOptionsTenants::class, 'index']);
Route::post('/generateOptionsIntegrationWhatsApp', [App\Http\GenerateOptions\GenerateOptionsIntegrationWhatsApp::class, 'index']);
Route::post('/generateOptionsTemplates', [App\Http\GenerateOptions\GenerateOptionsTemplates::class, 'index']);

Route::post('/generateOptionsCep', [App\Http\GenerateOptions\GenerateOptionsCep::class, 'index']);
Route::post('/generateOptionsStates', [App\Http\GenerateOptions\GenerateOptionsStates::class, 'index']);
Route::post('/generateOptionsCities', [App\Http\GenerateOptions\GenerateOptionsCities::class, 'index']);
