<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up()
	{
		Schema::create('users', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('tenant_id')->index();
			$table->uuid('uuid')->index()->unique();
			$table->string('username',45)->unique()->index();
			$table->string('password',255)->index();
			$table->string('people',1);
			$table->string('name',45)->nullable();
			$table->string('surname',45)->nullable();
			$table->string('corporate_name', 120)->nullable();
			$table->string('email',60)->index();
			$table->string('phone',60);
			$table->string('whatsapp',60);
			$table->string('avatar',200)->nullable();
			$table->string('subdomain',255)->index();
			$table->string('category',10)->index()->comment('MT - Master CL - Cliente CLB - Colaborador');
			$table->tinyInteger('link_confirm')->default(1);
			$table->tinyInteger('is_admin')->default(0)->index();
			$table->tinyInteger('situation')->default(1)->index();
			$table->timestamps();
			$table->softDeletes();
		});
	}
	
	public function down()
	{
		Schema::dropIfExists('users');
	}
};
