<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up()
	{
		Schema::create('access', function (Blueprint $table) {
			$table->id();
			$table->uuid('uuid')->index()->unique();
			$table->unsignedBigInteger('tenant_id')->index()->unique();
			$table->tinyInteger('period')->default(1)->comment('0 - Semestral 1 - Mensal 2 - Anual');
			$table->string('type', 1)->default('T')->index()->comment('T - Test P - Product')->index();
			$table->date('date_start')->index();
			$table->date('date_end')->index();
			$table->string('situation',1)->default('I')->index()->comment('I - Inactive A - Active S - Suspended E - Expiration  C - Canceled')->index();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::dropIfExists('access');
	}
};
