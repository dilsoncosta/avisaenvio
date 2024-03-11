<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	public function run()
	{
		\App\Models\Tenant::factory()->create(); 
		\App\Models\User::factory()->create();
		\App\Models\Access::factory()->create();
	}
}
