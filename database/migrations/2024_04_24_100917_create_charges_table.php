<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up()
	{
		Schema::create('charges', function (Blueprint $table) {
			$table->id();
			$table->uuid('uuid')->index()->unique();
			$table->unsignedBigInteger('tenant_id')->index();
			$table->tinyInteger('type')->default(2)->comment('0 - Deposito, 1 - Boleto Bancário, 2 - Cartão de Crédito, 3 - Pix');
			$table->text('description');
			$table->date('venc');
			$table->tinyInteger('situation')->default(0)->comment('0 - Pendente, 1 -Pago, 2 - Cancelado, 3 - Cartão Recusado');
			$table->decimal('total', 10, 2);
			$table->tinyInteger('ind_mod_order_tracking')->default(0);
			$table->tinyInteger('ind_mod_hotel')->default(0);
			$table->string('asaas_charge_id', 30)->nullable();
			$table->string('asaas_invoice_number', 30)->nullable();
			$table->string('asaas_transition_receipt_url', 255)->nullable();
			$table->date('asaas_client_payment_date')->nullable();
			$table->string('asaas_situation', 20)->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::dropIfExists('charges');
	}
};
