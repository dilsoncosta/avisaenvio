<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\{
	Order,
	IntegrationBestShipping
};
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class DownloadOrdersBestShipping extends Command
{
	protected $signature = 'send:download_order_best_shipping';
	private $url   = 'https://www.melhorenvio.com.br/api/v2/me/orders?per_page=700&status=posted';
	private $sleep = 1500000;
	private $shippingCompany = [
		'Correios'    => '0',
		'Jadlog'      => '1',
		'JeT'         => '2',
		'LATAM Cargo' => '3',
		'Loggi'       => '4'
	];

	protected $description = 'Comando para efetuar o download dos pedidos de cada cliente no melhor envio.';
	
	public function handle()
	{
		$integration_best_shippings = IntegrationBestShipping::select(
							'integration_best_shippings.tenant_id as tenant_id',
							'integration_best_shippings.token as token',
							'integration_best_shippings.id as id',
							'integration_best_shippings.token as token',
						)
						->where('integration_best_shippings.situation', '1')
						->get();
		
		if ($integration_best_shippings->isEmpty())
		{
			return false;
		}
		
		foreach ($integration_best_shippings as $key => $integration_best_shipping)
		{
			if(empty($integration_best_shipping->token)){ continue; }
			
			$response = Http::withHeaders([
				'Accept' => 'application/json',
				'Authorization' => 'Bearer '.$integration_best_shipping->token,
				'Content-type' => 'application/json',
				'User-Agent' => 'aplicacao dilsonlana@gmail.com'
			])->get($this->url);
			
			$orders = $response->object();
			
			if($response->status() != 200)
			{ 
				usleep($this->sleep);
				continue; 
			}
			
			foreach($orders->data as $item)
			{
				if(Order::where('code', $item->protocol)->where('tenant_id', $integration_best_shipping->tenant_id)->exists())
				{ continue; }

				if(strlen($item->to->document) <= 11)
				{
					$cpf_cnpj = $item->to->document;
				}
				else
				{
					$cpf_cnpj = $item->to->company_document;
				}
				
				$companyName = $item->service->company->name;
				if (!array_key_exists($companyName, $this->shippingCompany))
				{
					continue;
				}
				
				Order::create([
					'tenant_id'        => $integration_best_shipping->tenant_id,
					'uuid'             => str::uuid(),
					'code'             => $item->protocol,
					'cpf_cnpj'         => $cpf_cnpj,
					'destination'      => $item->to->name,
					'whatsapp'         => '55'.$item->to->phone,
					'object'           => $item->tracking,
					'integration'      => 0,
					'shipping_company' => $this->shippingCompany[$item->service->company->name],
					'last_situation'   => 0,
				]);
			}
		}
	}
}
