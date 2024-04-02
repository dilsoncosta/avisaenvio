<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up()
	{
		Schema::create('orders', function (Blueprint $table) {
			$table->id();
			$table->uuid('uuid')->index()->unique();
			$table->unsignedBigInteger('tenant_id')->index();
			$table->string('code', 40);
			$table->string('destination', 255);
			$table->string('whatsapp',60);
			$table->string('object', 60);
			$table->tinyInteger('integration')->default(0)->comment('0 - Melhor Envio, 1 - Importação Planilha, 2 - Cadastro Manual')->index();
			$table->tinyInteger('shipping_company')->default(0)->comment('0 - Correios, 1 - Jadlog')->index();
			$table->tinyInteger('last_situation')->default(0)->comment('0 Pendente, 1 - Pedido postado, 2 - Em trânsito, 3 - Em processo,  4 - Saiu entrega,  5 - Entregue,  6 - Em alerta,  7 - Com problemas')->index();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::dropIfExists('orders');
	}
};
