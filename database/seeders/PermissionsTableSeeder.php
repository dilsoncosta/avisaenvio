<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Permission;
use App\Models\Resource;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{
	// php artisan db:seed --class=PermissionsTableSeeder
	public function run()
	{
		DB::table('resources')->delete();
		DB::table('permissions')->delete();
		
		
		####
		# Module Template
		{
			Resource::create(
				[
								'id'   => 1,
								'name' => "Template",
								'uuid' => str::uuid(),
							 'order' => 1,
					 'situation' => 1,
					'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				]
			);
			
			Permission::create(
				[
									'id' => 1,
				 'resource_id' => 1,
								'name' => "access_template",
								'uuid' => str::uuid(),
							 'order' => 1,
				]
			);
			
			Permission::create(
				[
									'id' => 2,
				 'resource_id' => 1,
								'name' => "view_template",
								'uuid' => str::uuid(),
							 'order' => 2,
				]
			);
			
			Permission::create(
				[
									'id' => 3,
				 'resource_id' => 1,
								'name' => "edit_template",
								'uuid' => str::uuid(),
							 'order' => 3,
				]
			);
			
			Permission::create(
				[
									'id' => 4,
				 'resource_id' => 1,
								'name' => "delete_template",
								'uuid' => str::uuid(),
							 'order' => 4,
				]
			);
		}
		
		####
		# Module Rastreio
		{
			Resource::create(
				[
								'id'   => 2,
								'name' => "Rastreio",
								'uuid' => str::uuid(),
							 'order' => 2,
					 'situation' => 1,
					'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				]
			);
			
			Permission::create(
				[
									'id' => 5,
				 'resource_id' => 2,
								'name' => "access_tracking",
								'uuid' => str::uuid(),
							 'order' => 1,
				]
			);
			
			Permission::create(
				[
									'id' => 6,
				 'resource_id' => 2,
								'name' => "view_tracking",
								'uuid' => str::uuid(),
							 'order' => 2,
				]
			);
			
			Permission::create(
				[
									'id' => 8,
				 'resource_id' => 2,
								'name' => "delete_tracking",
								'uuid' => str::uuid(),
							 'order' => 4,
				]
			);
		}
		
		####
		# Module Collaborator
		{
			Resource::create(
				[
								'id'   => 3,
								'name' => "Colaborador",
								'uuid' => str::uuid(),
							 'order' => 3,
					 'situation' => 1,
					'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				]
			);
			
			Permission::create(
				[
									'id' => 9,
				 'resource_id' => 3,
								'name' => "access_config_collaborator",
								'uuid' => str::uuid(),
							 'order' => 1,
				]
			);
			
			Permission::create(
				[
									'id' => 10,
				 'resource_id' => 3,
								'name' => "view_config_collaborator",
								'uuid' => str::uuid(),
							 'order' => 2,
				]
			);
			
			Permission::create(
				[
									'id' => 11,
				 'resource_id' => 3,
								'name' => "edit_config_collaborator",
								'uuid' => str::uuid(),
							 'order' => 3,
				]
			);
			
			Permission::create(
				[
									'id' => 12,
				 'resource_id' => 3,
								'name' => "delete_config_collaborator",
								'uuid' => str::uuid(),
							 'order' => 4,
				]
			);
		}
		
		####
		# Module Integration WhatsApp
		{
			Resource::create(
				[
								'id'   => 4,
								'name' => "Integração WhatsApp",
								'uuid' => str::uuid(),
							 'order' => 4,
					 'situation' => 1,
					'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				]
			);
			
			Permission::create(
				[
									'id' => 13,
				 'resource_id' => 4,
								'name' => "access_config_integration_whatsapp",
								'uuid' => str::uuid(),
							 'order' => 1,
				]
			);
		}
		
		####
		# Module Import
		{
			Resource::create(
				[
								'id'   => 5,
								'name' => "Importação",
								'uuid' => str::uuid(),
							 'order' => 5,
					 'situation' => 1,
					'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				]
			);
			
			Permission::create(
				[
									'id' => 14,
				 'resource_id' => 5,
								'name' => "access_config_import",
								'uuid' => str::uuid(),
							 'order' => 1,
				]
			);
		}
	}
}
