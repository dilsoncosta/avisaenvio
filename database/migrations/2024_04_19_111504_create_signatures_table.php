<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up()
	{
		Schema::create('signatures', function (Blueprint $table) {
				$table->id();
				$table->uuid('uuid')->index()->unique();
				$table->unsignedBigInteger('tenant_id')->index();
				$table->tinyInteger('frequency')->default(1);
				$table->date('next_due_date');
				$table->tinyInteger('automatic_renovation')->default(1);
				$table->tinyInteger('situation')->default(1)->comment('0 - Pendente, 1 - Ativo, 2 - Cancelado');
				$table->date('date_canceled')->nullable();
				$table->tinyInteger('payment')->default(2)->comment('0 - Deposito, 1 - Boleto Bancário, 2 - Cartão de Crédito, 3 - Pix');
				$table->decimal('total', 10,2);
				$table->tinyInteger('ind_mod_order_tracking')->default(0);
				$table->tinyInteger('ind_mod_hotel')->default(0);
				$table->tinyInteger('address_type')->default(0);
				$table->string('address_corporate_reason', 60)->nullable();
				$table->string('address_cnpj', 15)->nullable();
				$table->string('address_cpf', 15)->nullable();
				$table->string('address_name', 60)->nullable();
				$table->string('address_surname', 60)->nullable();
				$table->string('address_email', 60);
				$table->string('address_whatsapp', 15);
				$table->string('address_phone', 15);
				$table->string('address_cep',10);
				$table->string('address_state',5);
				$table->string('address_street',255);
				$table->string('address_city',60);
				$table->string('address_neighborhood',120);
				$table->string('address_address', 120);
				$table->string('address_number',6);
				$table->string('address_complement',25)->nullable();
				$table->string('asaas_credit_card_number',30);
				$table->string('asaas_credit_card_brand',30);
				$table->string('asaas_credit_card_token',80);
				$table->string('asaas_object',40);
				$table->string('asaas_id',80);
				$table->string('asaas_date_created',15);
				$table->string('asaas_status',15);
				$table->string('asaas_customer_id',80);
				$table->text('asaas_description')->nullable();
				$table->timestamps();
				$table->softDeletes();
		});
	}
	
	public function down()
	{
		Schema::dropIfExists('signatures');
	}
};
