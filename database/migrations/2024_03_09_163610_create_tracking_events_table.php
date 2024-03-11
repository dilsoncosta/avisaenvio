<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up()
	{
		Schema::create('tracking_events', function (Blueprint $table) {
			$table->id();
			$table->uuid('uuid')->index()->unique();
			$table->unsignedBigInteger('tenant_id')->index();
			$table->unsignedBigInteger('tracking_id')->index();
			$table->unsignedBigInteger('template_id')->index();
			$table->dateTime('date_event');
			$table->char('status_event', 1)->default(0)->comment('1 - Objeto Postado, 2- Objeto Encaminhado, 3 - Objeto Saiu para Entrega, 4 - Objeto Entregue');
			$table->string('msg_event', 255);
			$table->char('status_send', 1)->default(0)->comment('0 - Pendente, 1 - Enviado, 2 - Falha');
			$table->string('msg_send', 255)->nullable();
			$table->timestamps();
		});
	}
	
	public function down()
	{
		Schema::dropIfExists('tracking_events');
	}
};
