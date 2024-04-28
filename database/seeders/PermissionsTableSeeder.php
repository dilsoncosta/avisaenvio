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
		# Module Order
		{
			Resource::create(
				[
								'id'   => 2,
								'name' => "Pedido",
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
								'name' => "access_order",
								'uuid' => str::uuid(),
							 'order' => 1,
				]
			);
			
			Permission::create(
				[
									'id' => 6,
				 'resource_id' => 2,
								'name' => "view_order",
								'uuid' => str::uuid(),
							 'order' => 2,
				]
			);

			Permission::create(
				[
									'id' => 7,
				 'resource_id' => 2,
								'name' => "edit_order",
								'uuid' => str::uuid(),
							 'order' => 3,
				]
			);
			
			Permission::create(
				[
									'id' => 8,
				 'resource_id' => 2,
								'name' => "delete_order",
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
								'name' => "access_config_import_order",
								'uuid' => str::uuid(),
							 'order' => 1,
				]
			);
		}
		
		####
		# Module Integration Best Billing
		{
			Resource::create(
				[
								'id'   => 6,
								'name' => "Integração Melhor Envio",
								'uuid' => str::uuid(),
							 'order' => 6,
					 'situation' => 1,
					'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				]
			);
			
			Permission::create(
				[
									'id' => 15,
				 'resource_id' => 6,
								'name' => "access_config_integration_best_shipping",
								'uuid' => str::uuid(),
							 'order' => 1,
				]
			);
		}
		
		####
		# Module Hospitality
		{
			Resource::create(
				[
								'id'   => 7,
								'name' => "Hotelaria",
								'uuid' => str::uuid(),
							 'order' => 7,
					 'situation' => 1,
					'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				]
			);
			
			Permission::create(
				[
									'id' => 16,
				 'resource_id' => 7,
								'name' => "access_config_hospitality",
								'uuid' => str::uuid(),
							 'order' => 1,
				]
			);
		}
		
		####
		# Module Guest
		{
			Resource::create(
				[
								'id'   => 8,
								'name' => "Hospede",
								'uuid' => str::uuid(),
							 'order' => 8,
					 'situation' => 1,
					'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				]
			);
			
			Permission::create(
				[
									'id' => 17,
				 'resource_id' => 8,
								'name' => "access_guest",
								'uuid' => str::uuid(),
							 'order' => 1,
				]
			);
			
			Permission::create(
				[
									'id' => 18,
				 'resource_id' => 8,
								'name' => "view_guest",
								'uuid' => str::uuid(),
							 'order' => 2,
				]
			);
			
			Permission::create(
				[
									'id' => 19,
				 'resource_id' => 8,
								'name' => "edit_guest",
								'uuid' => str::uuid(),
							 'order' => 3,
				]
			);
			
			Permission::create(
				[
									'id' => 20,
				 'resource_id' => 8,
								'name' => "delete_guest",
								'uuid' => str::uuid(),
							 'order' => 4,
				]
			);
		}

		####
		# Module Financial
		{
			Resource::create(
				[
								'id'   => 9,
								'name' => "Financeiro",
								'uuid' => str::uuid(),
							 'order' => 9,
					 'situation' => 1,
					'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				]
			);
			
			Permission::create(
				[
									'id' => 21,
				 'resource_id' => 9,
								'name' => "access_config_financial",
								'uuid' => str::uuid(),
							 'order' => 1,
				]
			);
		}
	}
}
