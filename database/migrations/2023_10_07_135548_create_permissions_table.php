<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up()
	{
		Schema::create('permissions', function (Blueprint $table) {
			$table->bigInteger('id')->unique();
			$table->uuid('uuid')->index()->unique();
			$table->unsignedBigInteger('resource_id')->index();
			$table->string('name')->unique();
			$table->char('order');
			$table->timestamps();
			$table->softDeletes();
		});
	}
	
	public function down()
	{
		Schema::dropIfExists('permissions');
	}
};
