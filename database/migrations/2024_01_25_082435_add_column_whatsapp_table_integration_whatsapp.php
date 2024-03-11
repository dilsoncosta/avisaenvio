<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up()
	{
		Schema::table('integration_whatsapp', function ($table) {
			$table->string('whatsapp',60)->nullable()->after('session_name');
		});
	}
	
	public function down()
	{
		Schema::table('integration_whatsapp', function ($table) {
			$table->dropColumn('whatsapp');
		});
	}
};
