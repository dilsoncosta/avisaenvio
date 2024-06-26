<?php

use Illuminate\Support\Facades\Route;

Route::group([], base_path("routes/api-not-auth.php")); 

Route::middleware('auth:sanctum')->group(function (){
	
	Route::group([], base_path("routes/api-auth.php"));
	
	Route::group([], base_path("routes/api-dashboard.php"));

	Route::group([], base_path("routes/api-webhook.php"));

	Route::group([], base_path("routes/api-account.php"));
	Route::group([], base_path("routes/api-template.php"));
	Route::group([], base_path("routes/api-collaborator.php"));
	Route::group([], base_path("routes/api-generate-options.php"));
	Route::group([], base_path("routes/api-order.php"));
	Route::group([], base_path("routes/api-guest.php"));
	Route::group([], base_path("routes/api-financial.php"));
	
	Route::group([], base_path("routes/api-cfg-integration-whatsapp.php"));
	Route::group([], base_path("routes/api-cfg-import-order.php"));
	Route::group([], base_path("routes/api-cfg-integration-best-shipping.php")); 
	Route::group([], base_path("routes/api-cfg-integration-nuvem-shop.php"));
	Route::group([], base_path("routes/api-cfg-hospitality.php")); 
	Route::group([], base_path("routes/api-cfg-integration-tray.php")); 
	
	// Administrator
	Route::group(['prefix'=>'admin'], function(){
		Route::group([], base_path("routes/api-adm-access.php"));
		Route::group([], base_path("routes/api-adm-resource.php"));
		Route::group([], base_path("routes/api-adm-permission.php"));
		Route::group([], base_path("routes/api-adm-token-whatsapp.php"));
	});
});
