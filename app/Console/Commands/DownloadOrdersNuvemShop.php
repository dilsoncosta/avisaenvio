<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\{
	Order,
	IntegrationNuvemShop
};
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class DownloadOrdersNuvemShop extends Command
{
	protected $signature = 'send:download_order_nuvem_shop';
	private $sleep = 1500000;
	private $shippingCompany = [
		'ne-correios-sedex' => '0',
		'Jadlog'            => '1',
		'JeT'               => '2',
		'LATAM Cargo'       => '3',
		'Loggi'             => '4'
	];

	protected $description = 'Comando para efetuar o download dos pedidos de cada cliente na nuvem shop.';
	
	public function handle()
	{
		$integration_nuvem_shops = IntegrationNuvemShop::select(
							'integration_nuvem_shops.tenant_id as tenant_id',
							'integration_nuvem_shops.access_token as access_token',
							'integration_nuvem_shops.user_id as user_id',
							'integration_nuvem_shops.id as id',
						)
						->where('integration_nuvem_shops.situation', '1')
						->get();
		
		if ($integration_nuvem_shops->isEmpty())
		{
			return false;
		}
		
		foreach ($integration_nuvem_shops as $key => $integration_nuvem_shop)
		{
			$startDate = Carbon::now()->format('Y-m-d').'T00:00:39+0000';
			$endDate = Carbon::now()->format('Y-m-d').'T23:59:59+0000';
			
			$headers = [
				'Accept'         => 'application/json',
				'Authentication' => 'bearer '.$integration_nuvem_shop->access_token,
				'Content-type'   => 'application/json',
				'User-Agent'     => config('app.api_nuvem_shop_user_agent')
			];
			
			$queryParams = [
				'payment_status'  => 'paid',
				'updated_at_min'  => $startDate,
				'updated_at_max'  => $endDate,
				'shipping_status' => 'fulfilled',
				'fields'          => 'number,contact_name,contact_phone,shipping_tracking_number,shipping_option_code,contact_identification'
			];
			
			$response = Http::withHeaders($headers)->get(config('app.api_nuvem_shop_url').'/'.$integration_nuvem_shop->user_id.'/orders', $queryParams);
			
			$orders = $response->object();
			
			if($response->status() != 200)
			{ 
				usleep($this->sleep);
				continue; 
			}
			
			foreach($orders as $item)
			{
				if(Order::where('code', $item->number)
							->where('tenant_id', $integration_nuvem_shop->tenant_id)
							->where('integration', 3)
							->exists()){ continue; }
				
				if(strlen($item->contact_identification) <= 11)
				{
					$cpf_cnpj = $item->contact_identification;
				}
				else
				{
					$cpf_cnpj = $item->contact_identification;
				}
				
				$companyName = $item->shipping_option_code;
				if (!array_key_exists($companyName, $this->shippingCompany))
				{
					continue;
				}
				
				Order::create([
					'tenant_id'        => $integration_nuvem_shop->tenant_id,
					'uuid'             => str::uuid(),
					'code'             => $item->number,
					'cpf_cnpj'         => $cpf_cnpj,
					'destination'      => $item->contact_name,
					'whatsapp'         => str_replace("+", "", $item->contact_phone),
					'object'           => $item->shipping_tracking_number,
					'integration'      => 3,
					'shipping_company' => $this->shippingCompany[$companyName],
					'last_situation'   => 0,
				]);
			}
		}
	}
}
