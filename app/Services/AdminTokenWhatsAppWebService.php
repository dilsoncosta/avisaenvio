<?php
namespace App\Services;

use App\Models\IntegrationWhatsApp;

class AdminTokenWhatsAppWebService
{
	private $adminTokenWhatsAppWebService;
	private $perPage = 20;
	
	public function __construct(IntegrationWhatsApp $adminTokenWhatsAppWebService)
	{
		$this->adminTokenWhatsAppWebService = $adminTokenWhatsAppWebService;
	}
	
	public function getAllAdminTokenWhatsAppWebs($request)
	{
		return $this->adminTokenWhatsAppWebService
								->with('client.user')
								->where(function($query) use ($request)
								{
									if(isset($request->srch_client) && !empty($request->srch_client))
									{
										$query->where('tenant_id', $request->srch_client);
									}
									if(isset($request->srch_port) && !empty($request->srch_port))
									{
										$query->where('port', $request->srch_port);
									}
									if(isset($request->srch_situation) && (!empty($request->srch_situation) || $request->srch_situation == 0))
									{
										$query->where('situation', $request->srch_situation);
									}
								})
								->orderBy('id', 'DESC')
								->paginate($this->perPage);
	}

	public function createTokenWhatsappWeb($request)
	{
		$dataTokenWhatsAppWeb = [
			'tenant_id' => $request->client_id,
			'whatsapp'  => $request->whatsapp, 
			'app_key'   => config('app.api_whatsapp_secret_key'), 
			'title'     => $request->title, 
			'url'       => $request->url,
			'port'      => $request->port, 
			'situation' => $request->situation, 
		];
		 
		$this->adminTokenWhatsAppWebService->create($dataTokenWhatsAppWeb);
	}
	
	public function updateTokenWhatsappWeb($request)
	{
		$dataTokenWhatsAppWeb = [
			'url'       => $request->url,
			'whatsapp'  => $request->whatsapp, 
			'title'     => $request->title, 
			'port'      => $request->port, 
			'situation' => $request->situation, 
		 ];
		 
		 $this->adminTokenWhatsAppWebService->where('id', $request->id)
		 			->update($dataTokenWhatsAppWeb);
	}
	
	public function getTokenWhatsAppWebById($id)
	{
		return $this->adminTokenWhatsAppWebService->with('client.user')
								->where('id', $id)
								->first();
	}

	public function deleteTokenWhatsAppWebs($ids)
	{
		$dels = explode(",", $ids);
		
		foreach ($dels as $del)
		{
			$this->adminTokenWhatsAppWebService->where('id', $del)->delete();
		}
	}
}
