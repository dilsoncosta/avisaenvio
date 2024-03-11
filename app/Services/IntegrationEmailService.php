<?php
namespace App\Services;

use App\Models\IntegrationEmail;

class IntegrationEmailService
{
	private $integrationEmail;
	private $perPage = 20;
	
	public function __construct(IntegrationEmail $integrationEmail)
	{
		$this->integrationEmail = $integrationEmail;
	}

	public function getAllIntegrationEmails($request)
	{
		return $this->integrationEmail
								->where(function($query) use ($request)
								{
									if(isset($request->srch_name) && !empty($request->srch_name))
									{
										$query->where('name', 'LIKE', '%'.$request->srch_name.'%');
									}
									if(isset($request->srch_situation) && (!empty($request->srch_situation) || $request->srch_situation == 0))
									{
										$query->where('situation', $request->srch_situation);
									}
								})
								->orderBy('id', 'DESC')
								->paginate($this->perPage);
	}

	public function storeIntegrationEmail($request)
	{
		$dataIntegrationEmail = [
			'title'     => $request->title,
			'host'      => $request->host,
			'port'      => $request->port,
			'user'      => $request->user,
			'password'  => $request->password,
			'email'     => $request->email,
			'situation' => $request->situation,
		 ];
		 
		 $this->integrationEmail->create($dataIntegrationEmail);
	}

	public function updateIntegrationEmail($request)
	{
		$dataIntegrationEmail = [
			'title'     => $request->title,
			'host'      => $request->host,
			'port'      => $request->port,
			'user'      => $request->user,
			'password'  => $request->password,
			'email'     => $request->email,
			'situation' => $request->situation, 
		];
		
		$this->integrationEmail->where('id', $request->id)->update($dataIntegrationEmail);
	}

	public function getIntegrationEmailById($id)
	{
		return $this->integrationEmail->where('id', $id)
								->first();
	}

	public function deleteIntegrationEmails($ids)
	{
		$dels = explode(",",$ids);

		foreach($dels as $del)
		{
			$this->integrationEmail->where('id', $del)
					->delete();
		}
	}

	public function checkName($title, $id, $flow)
	{
		$query =  $this->integrationEmail->where('title', $title);
		if($flow == 1)
		{
			$query->where('id', '!=', $id);
		}
		$query->count();
	}
}
