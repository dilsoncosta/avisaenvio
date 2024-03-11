<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up()
	{
		Schema::create('resources', function (Blueprint $table) {
			$table->bigInteger('id')->unique();
			$table->uuid('uuid')->index()->unique();
			$table->string('name');
			$table->integer('order')->unique();
			$table->tinyInteger('situation')->default(0)->index();
			$table->timestamps();
			$table->softDeletes();
		});
	}
	
	public function down()
	{
		Schema::dropIfExists('resources');
	}
};
