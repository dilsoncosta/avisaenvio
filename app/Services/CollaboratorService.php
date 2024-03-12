<?php

namespace App\Services;

use App\Models\Collaborator;
use App\Models\{
	User,
	PermissionCollaborator,
	Resource
};
use Illuminate\Support\Facades\Hash;

class CollaboratorService
{
	private $user;
	private $collaborator;
	private $permissionCollaborator;
	private $resource;
	private $perPage = 20;

	public function __construct(User $user, 
		Collaborator $collaborator, 
		PermissionCollaborator $permissionCollaborator,
		Resource $resource
	)
	{
		$this->user                   = $user;
		$this->collaborator           = $collaborator;
		$this->permissionCollaborator = $permissionCollaborator;
		$this->resource               = $resource;
	}
	
	public function getAllCollaborator($request)
	{
		return $this->collaborator->with(['user', 'permissions'])
								->whereHas('user', function($query) use($request)
								{
									if(isset($request->srch_username) && !empty($request->srch_username))
									{
										$query->where('username', 'LIKE', '%'.$request->srch_username.'%');
									}
									if(isset($request->srch_email) && !empty($request->srch_email))
									{
										$query->where('email', 'LIKE', '%'.$request->srch_email.'%');
									}
									if(isset($request->srch_situation) && (!empty($request->srch_situation) || $request->srch_situation == 0))
									{
										$query->where('situation', '=', $request->srch_situation);
									}
								})
								->orderBy('id', 'DESC')
								->paginate($this->perPage);
	}
	
	public function getAllResources()
	{
		return $this->resource
								->with('permissions')
								->orderBy('order', 'ASC')
								->get();
	}
	
	public function createCollaborator($request)
	{
		$userData = $this->user->create([
     'username'                 => $request->username, 
     'people'                   => $request->people, 
     'password'                 => Hash::make($request->password), 
     'name'                     => mb_strtoupper($request->name), 
     'surname'                  => mb_strtoupper($request->surname), 
     'email'                    => $request->email, 
     'phone'                    => $request->phone, 
     'whatsapp'                 => $request->whatsapp, 
     'category'                 => 'CLB', 
     'subdomain'                => auth()->user()->tenant->subdomain,
     'is_admin'                 => 1,
     'link_confirm'             => 1,
     'situation'                => $request->situation
		]);
		
		$datacollaborator = [
     'user_id' => $userData->id,
		];
		
		$collaborator = $this->collaborator->create($datacollaborator);
		
		if($request->permissionIds)
		{
			foreach($request->permissionIds as $item)
			{
				$this->permissionCollaborator->create([
					'collaborator_id' => $collaborator->id, 
					'permission_id'   => $item,
				]);
			}
		}
	}
	
	public function updateCollaborator($request)
	{
		$collaborator = $this->collaborator->where('user_id', $request->user_id)->first();
		
		$this->user
				->where('id', $request->user_id)
				->update([
					'username'  => $request->username, 
					'name'      => mb_strtoupper($request->name), 
					'surname'   => mb_strtoupper($request->surname), 
					'email'     => $request->email, 
					'phone'     => $request->phone, 
					'whatsapp'  => $request->whatsapp,
					'situation' => $request->situation
				]);
		
		$this->permissionCollaborator->where('collaborator_id', $collaborator->id)->delete();
		
		if($request->permissionIds)
		{
			foreach($request->permissionIds as $item)
			{
				$this->permissionCollaborator->create([
					'collaborator_id' => $collaborator->id, 
					'permission_id'   => $item,
				]);
			}
		}
	}
	
	public function getCollaboratorById($user_id)
	{
		return $this->collaborator
								->where('user_id', $user_id)
								->first();
	}

	public function deleteCollaborator($request)
	{
		$dels = explode(",",$request->ids);
		
		foreach($dels as $del)
		{
			$collaborator = $this->collaborator->find($del);
			
			if(!$collaborator)
			{
				continue;
			}
			
			$this->collaborator->where('id', $collaborator->id)
						->delete();
			$this->user->where('id', $collaborator->user_id)
						->delete();
			$this->permissionCollaborator->where('collaborator_id', $collaborator->id)->delete();
		}
	}
}
