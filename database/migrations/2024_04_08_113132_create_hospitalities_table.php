<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up()
	{
		Schema::create('hospitalities', function (Blueprint $table) {
			$table->id();
			$table->uuid('uuid')->index()->unique();
			$table->unsignedBigInteger('tenant_id')->index();
			$table->tinyInteger('ind_msg_1')->nullable(0);
			$table->unsignedBigInteger('msg_1_template_id')->nullable();
			$table->tinyInteger('ind_msg_2')->default(0);
			$table->unsignedBigInteger('msg_2_template_id')->nullable();
			$table->tinyInteger('ind_msg_3')->default(0);
			$table->unsignedBigInteger('msg_3_template_id')->nullable();
			$table->tinyInteger('ind_msg_4')->default(0);
			$table->unsignedBigInteger('msg_4_template_id')->nullable();
			$table->tinyInteger('ind_msg_5')->default(0);
			$table->unsignedBigInteger('msg_5_template_id')->nullable();
			$table->tinyInteger('ind_msg_6')->default(0);
			$table->unsignedBigInteger('msg_6_template_id')->nullable();
			$table->timestamps();
		});
	}
	
	public function down()
	{
		Schema::dropIfExists('hospitalities');
	}
};
