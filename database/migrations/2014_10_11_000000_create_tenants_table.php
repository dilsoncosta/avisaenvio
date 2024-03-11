<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up()
	{
		Schema::create('tenants', function (Blueprint $table) {
			$table->id();
			$table->uuid('uuid')->index()->unique();
			$table->string('subdomain',255)->index()->unique();
			$table->timestamps();
			$table->softDeletes();
		});
	}
	
	public function down()
	{
		Schema::dropIfExists('tenants');
	}
};
