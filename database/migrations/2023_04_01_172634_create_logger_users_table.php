<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up()
	{
		Schema::create('logger_users', function (Blueprint $table) {
			$table->id();
			$table->uuid('uuid')->index()->unique();
			$table->string('username',255);
			$table->dateTime('date');
			$table->string('description',255);
			$table->string('ip', 45);
			$table->tinyInteger('type')->comment('1 - Login , 2 -Logout , 3 - Atividade');
		});
	}
	
	public function down()
	{
		Schema::dropIfExists('logger_users');
	}
};
