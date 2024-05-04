<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up()
	{
		Schema::create('integration_nuvem_shops', function (Blueprint $table) {
			$table->id();
			$table->uuid('uuid')->index()->unique();
			$table->unsignedBigInteger('tenant_id')->index();
			$table->text('access_token')->nullable();
			$table->string('scope', 300)->nullable();
			$table->string('token_type', 12)->nullable();
			$table->string('idapp', 12)->nullable();
			$table->string('user_id', 12)->nullable();
			$table->string('code', 120)->nullable();
			$table->tinyInteger('situation')->default(0); 
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::dropIfExists('integration_nuvem_shops');
	}
};
