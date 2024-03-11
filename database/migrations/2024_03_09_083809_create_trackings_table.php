<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up()
	{
		Schema::create('trackings', function (Blueprint $table) {
			$table->id();
			$table->uuid('uuid')->index()->unique();
			$table->unsignedBigInteger('tenant_id')->index();
			$table->string('destination', 255);
			$table->string('whatsapp',60);
			$table->string('object', 60);
			$table->tinyInteger('situation')->default(0)->comment('0 - Pendente, 1 - Em Andamento, 2 - Concluido')->index();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::dropIfExists('trackings');
	}
};
