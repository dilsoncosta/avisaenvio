<?php 
namespace App\Services;

use App\Models\{
	Permission,
	Resource
};

class AdminPermissionService
{
	private $permission;
	private $resource;
	private $perPage = 20;
	
	public function __construct(Permission $permission, Resource $resource)
	{
		$this->permission = $permission;
		$this->resource = $resource;
	}
	
	public function getAllPermissions($request)
	{
		return $this->permission
								->with('permission_resource')
								->where(function($query) use ($request)
								{
									if(isset($request->srch_resource_id) && !empty($request->srch_resource_id))
									{
										$query->where('resource_id', $request->srch_resource_id);
									}
									if(isset($request->srch_name) && !empty($request->srch_name))
									{
										$query->where('name', 'LIKE' , '%'.$request->name.'%');
									}
								})
								->orderBy('id', 'DESC')
								->paginate($this->perPage);
	}

	public function storePermission($request)
	{
		$dataPermission = [
			'resource_id' => $request->resource_id,
			'name'        => $request->name,
			'order'       => $request->order,
		];
		
		$this->permission->create($dataPermission);
	}

	public function updatePermission($request)
	{
		$dataPermission = [
			'resource_id' => $request->resource_id,
			'name'        => $request->name,
			'order'       => $request->order,
		];
		
		$this->permission->where('id', $request->id)
	 			->update($dataPermission);
	}
	
	public function getPermissionById($id)
	{
		return $this->permission->with('permission_resource')
					->where('id', $id)
					->first();
	}

	public function checkExistedResource($resource_id)
	{
		$query = $this->resource->where('id', $resource_id);
			return $query->count();
	}
	
	public function checkName($name, $flow, $id)
	{
		$query =  $this->permission->where('name', $name);
					if($flow == 1)
					{
						$query->where('id', '!=', $id);
					}
		return $query->count();
	}

	public function deletePermissions($ids)
	{
		$dels = explode(",", $ids);
		
		foreach ($dels as $del)
		{
			$this->permission->where('id', $del)->delete();
		}
	}
}
