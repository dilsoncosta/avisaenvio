<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up()
	{
		Schema::create('templates', function (Blueprint $table) {
			$table->id();
			$table->uuid('uuid')->index()->unique();
			$table->unsignedBigInteger('tenant_id')->index();
			$table->tinyInteger('type')->default(1)->index();
			$table->string('title', 255)->index();
			$table->text('message')->nullable();
			$table->tinyInteger('situation')->default(0)->index();
			$table->string('filename_1',255)->nullable();
			$table->string('filename_storage_1',255)->nullable();
			$table->string('file_1',255)->nullable();
			$table->string('ext_1',5)->nullable();
			$table->string('size_1',10)->nullable();
			$table->string('filename_2',255)->nullable();
			$table->string('filename_storage_2',255)->nullable();
			$table->string('file_2',255)->nullable();
			$table->string('ext_2',5)->nullable();
			$table->string('size_2',10)->nullable();
			$table->string('filename_3',255)->nullable();
			$table->string('filename_storage_3',255)->nullable();
			$table->string('file_3',255)->nullable();
			$table->string('ext_3',5)->nullable();
			$table->string('size_3',10)->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::dropIfExists('crm_templates');
	}
};
