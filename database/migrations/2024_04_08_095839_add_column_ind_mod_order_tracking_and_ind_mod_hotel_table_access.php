<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up()
	{
		Schema::table('access', function ($table) {
			$table->tinyInteger('ind_mod_order_tracking')->default(0)->after('type');
			$table->tinyInteger('ind_mod_hotel')->default(0)->after('ind_mod_order_tracking');
		});
	}

	public function down()
	{
		Schema::table('access', function ($table) {
			$table->dropColumn('ind_mod_order_tracking');
			$table->dropColumn('ind_mod_hotel');
		});
	}
};
