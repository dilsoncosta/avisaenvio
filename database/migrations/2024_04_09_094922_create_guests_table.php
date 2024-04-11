<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up()
	{
		Schema::create('guests', function (Blueprint $table) {
			$table->id();
			$table->uuid('uuid')->index()->unique();
			$table->unsignedBigInteger('tenant_id')->index();
			$table->unsignedBigInteger('hospitality_id')->index();
			$table->string('name_surname', 60);
			$table->string('whatsapp', 60);
			$table->date('date_checkin');
			$table->date('date_checkout');
			$table->tinyInteger('situation')->default(0); 
			$table->tinyInteger('ind_msg_1')->nullable(0);
			$table->unsignedBigInteger('msg_1_template_id')->nullable();
			$table->char('msg_1_status_send', 1)->default(0)->comment('0 - Pendente, 1 - Enviado, 2 - Falha');
			$table->string('msg_1_msg_send', 255)->nullable();
			$table->tinyInteger('ind_msg_2')->nullable(0);
			$table->unsignedBigInteger('msg_2_template_id')->nullable();
			$table->char('msg_2_status_send', 1)->default(0)->comment('0 - Pendente, 1 - Enviado, 2 - Falha');
			$table->string('msg_2_msg_send', 255)->nullable();
			$table->tinyInteger('ind_msg_3')->nullable(0);
			$table->unsignedBigInteger('msg_3_template_id')->nullable();
			$table->char('msg_3_status_send', 1)->default(0)->comment('0 - Pendente, 1 - Enviado, 2 - Falha');
			$table->string('msg_3_msg_send', 255)->nullable();
			$table->tinyInteger('ind_msg_4')->nullable(0);
			$table->unsignedBigInteger('msg_4_template_id')->nullable();
			$table->char('msg_4_status_send', 1)->default(0)->comment('0 - Pendente, 1 - Enviado, 2 - Falha');
			$table->string('msg_4_msg_send', 255)->nullable();
			$table->tinyInteger('ind_msg_5')->nullable(0);
			$table->unsignedBigInteger('msg_5_template_id')->nullable();
			$table->char('msg_5_status_send', 1)->default(0)->comment('0 - Pendente, 1 - Enviado, 2 - Falha');
			$table->string('msg_5_msg_send', 255)->nullable();
			$table->tinyInteger('ind_msg_6')->nullable(0);
			$table->unsignedBigInteger('msg_6_template_id')->nullable();
			$table->char('msg_6_status_send', 1)->default(0)->comment('0 - Pendente, 1 - Enviado, 2 - Falha');
			$table->string('msg_6_msg_send', 255)->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::dropIfExists('guests');
	}
};
