<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up()
	{
		Schema::create('order_events', function (Blueprint $table) {
			$table->id();
			$table->uuid('uuid')->index()->unique();
			$table->unsignedBigInteger('tenant_id')->index();
			$table->unsignedBigInteger('order_id')->index();
			$table->unsignedBigInteger('template_id')->index();
			$table->dateTime('date_event');
			$table->char('status_event', 1)->default(0)->comment('0 - Pendente, 1 - Pedido Postado, 2- Em Trânsito, 3 - Saiu Entrega, 4 - Entregue, 5 - Alerta, 6 - Com Problemas');
			$table->string('msg_event', 255);
			$table->char('status_send', 1)->default(0)->comment('0 - Pendente, 1 - Enviado, 2 - Falha');
			$table->string('msg_send', 255)->nullable();
			$table->timestamps();
		});
	}
	
	public function down()
	{
		Schema::dropIfExists('order_events');
	}
};
