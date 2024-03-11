<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up()
	{
		Schema::create('integration_whatsapp', function (Blueprint $table) {
			$table->id();
			$table->uuid('uuid')->index()->unique();
			$table->unsignedBigInteger('tenant_id')->index();
			$table->string('title',255);
			$table->string('url',255);
			$table->string('port',12);
			$table->string('app_key',255)->nullable();
			$table->string('session_name',255)->nullable();
			$table->tinyInteger('situation')->default(0)->index(); 
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::dropIfExists('integration_whatsapp');
	}
};
