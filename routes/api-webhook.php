<?php
use Illuminate\Support\Facades\Route;

Route::post('/webhook/chargeAsaas', [App\Http\Webhook\ChargeAsaas::class, 'index']);