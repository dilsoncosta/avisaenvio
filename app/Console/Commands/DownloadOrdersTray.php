<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\{
	Order,
	IntegrationTray
};
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class DownloadOrdersTray extends Command
{
	protected $signature = 'send:download_order_tray';
	private $sleep = 1500000;
	private $shippingCompany = [
		'correios'          => '0',
		'Correios'          => '0',
		'CORREIOS'          => '0',
		'Jadlog'            => '1',
		'jadlog'            => '1',
		'JADLOG'            => '1',
		'JeT'               => '2',
		'LATAM Cargo'       => '3',
		'Loggi'             => '4'
	];
	
	protected $description = 'Comando para efetuar o download dos pedidos de cada cliente na tray.';
	
	public function handle()
	{
		$integration_trays = IntegrationTray::select(
							'integration_trays.tenant_id as tenant_id',
							'integration_trays.access_token as access_token',
							'integration_trays.api_address as api_address',
							'integration_trays.date_expiration_access_token as date_expiration_access_token',
							'integration_trays.date_expiration_refresh_token as date_expiration_refresh_token',
							'integration_trays.code as code',
							'integration_trays.refresh_token as refresh_token',
							'integration_trays.id as id',
						)
						->where('integration_trays.situation', '1')
						->get();
		
		if ($integration_trays->isEmpty())
		{
			return false;
		}
		
		foreach ($integration_trays as $key => $integration_tray)
		{

      
			if($integration_tray->date_expiration_refresh_token)
			{
				$expirationRefreshtokenDateTime = Carbon::parse($integration_tray->date_expiration_refresh_token);
				
				if ($expirationRefreshtokenDateTime->isPast())
				{
					$queryParams = [
						'consumer_key'     => config('app.api_consumer_key'),
						'consumer_secret'  => config('app.api_consumer_secret'),
						'code'             => $integration_tray->code,
					];

					$response = Http::post($integration_tray->api_address.'/auth', $queryParams);
					
					if($response->status() != 200)
					{ 
						usleep($this->sleep);
						continue; 
					}
					
					$dataExpRefreshTokenTray = $response->object();
					
					$this->updateIntegrationTray($integration_tray->id, [
						'access_token'                  => $dataExpRefreshTokenTray->access_token,
						'refresh_token'                 => $dataExpRefreshTokenTray->refresh_token,
						'date_expiration_refresh_token' => $dataExpRefreshTokenTray->date_expiration_refresh_token,
						'date_expiration_access_token'  => $dataExpRefreshTokenTray->date_expiration_access_token,
						'date_activated'                => $dataExpRefreshTokenTray->date_activated,
					]);
					
					$integration_tray->access_token  = $dataExpRefreshTokenTray->access_token;
					$integration_tray->refresh_token = $dataExpRefreshTokenTray->refresh_token;
				}
			}
			
			if($integration_tray->date_expiration_access_token)
			{
				$expirationAccessTimeDateTime = Carbon::parse($integration_tray->date_expiration_access_token);
				
				if ($expirationAccessTimeDateTime->isPast())
				{
					$response = Http::get($integration_tray->api_address.'/auth?refresh_token='.$integration_tray->refresh_token);
					
					if($response->status() != 200)
					{ 
						usleep($this->sleep);
						continue; 
					}
					
					$dataExpAccessTokenTray = $response->object();
					
					$this->updateIntegrationTray($integration_tray->id, [
						'access_token'                  => $dataExpAccessTokenTray->access_token,
						'refresh_token'                 => $dataExpAccessTokenTray->refresh_token,
						'date_expiration_refresh_token' => $dataExpAccessTokenTray->date_expiration_refresh_token,
						'date_expiration_access_token'  => $dataExpAccessTokenTray->date_expiration_access_token,
						'date_activated'                => $dataExpAccessTokenTray->date_activated,
					]);
					
					$integration_tray->access_token  = $dataExpAccessTokenTray->access_token;
					$integration_tray->refresh_token = $dataExpAccessTokenTray->refresh_token;
				}
			}
			
			$startDate = Carbon::now()->format('Y-m-d');
			
			$queryParams = [
				'access_token' => $integration_tray->access_token,
				'sort'         => 'id_desc',
				'page'         => '1',
				'limit'        => '1000',
				'status'       => 'ENVIADO',
				'modified'     => $startDate
			];
			
			$response = Http::get($integration_tray->api_address.'/orders', $queryParams);
			
			$orders = $response->object();
			
			if($response->status() != 200)
			{ 
				usleep($this->sleep);
				continue; 
			}
			
			foreach($orders->Orders as $item)
			{
				if(Order::where('code', $item->Order->id)
							->where('tenant_id', $integration_tray->tenant_id)
							->where('integration', 4)
							->exists()){ continue; }
				
				$response = Http::get($integration_tray->api_address.'/customers/'.$item->Order->customer_id.'?access_token='.$integration_tray->access_token);
				
				$client = $response->object();
				
				if($response->status() != 200)
				{ 
					usleep($this->sleep);
					continue; 
				}
				
				if($client->Customer->cpf)
				{
					$cpf_cnpj = $client->Customer->cpf;
				}
				else
				{
					$cpf_cnpj = $client->Customer->cnpj;
				}
				
				$companyName = $item->Order->shipment;
				if (!array_key_exists($companyName, $this->shippingCompany) || empty($client->Customer->name) || 
				empty($client->Customer->cellphone) || empty($item->Order->sending_code) || empty($cpf_cnpj) || empty($item->Order->id))
				{
					continue;
				}
				
				Order::create([
					'tenant_id'        => $integration_tray->tenant_id,
					'uuid'             => str::uuid(),
					'code'             => $item->Order->id,
					'cpf_cnpj'         => $cpf_cnpj,
					'destination'      => $client->Customer->name,
					'whatsapp'         => '55'.preg_replace('/\D/', '', $client->Customer->cellphone),
					'object'           => $item->Order->sending_code,
					'integration'      => 4,
					'shipping_company' => $this->shippingCompany[$companyName],
					'last_situation'   => 0,
				]);
				
			}
		}
	}
	
	private function updateIntegrationTray($id, $data)
	{
		IntegrationTray::where('id', $id)->update($data);
	}
}
