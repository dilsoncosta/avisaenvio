<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up()
	{
		Schema::create('integration_trays', function (Blueprint $table) {
			$table->id();
			$table->uuid('uuid')->index()->unique();
			$table->unsignedBigInteger('tenant_id')->index();
			$table->string('url_store', 250)->nullable();
			$table->text('access_token')->nullable();
			$table->string('code', 250)->nullable();
			$table->dateTime('date_expiration_access_token')->nullable();
			$table->dateTime('date_expiration_refresh_token')->nullable();
			$table->dateTime('date_activated')->nullable();
			$table->text('refresh_token')->nullable();
			$table->tinyInteger('situation')->default(0); 
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::dropIfExists('integration_trays');
	}
};
