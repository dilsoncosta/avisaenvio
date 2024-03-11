<?php 
namespace App\Services;

use App\Models\Resource;

class AdminResourceService
{
	private $resource;
	private $perPage = 20;
	
	public function __construct(Resource $resource)
	{
		$this->resource = $resource;
	}
	
	public function getAllResources($request)
	{
		return $this->resource
								->with('permissions')
								->where(function($query) use ($request)
								{
									if(isset($request->srch_name) && !empty($request->srch_name))
									{
										$query->where('name', 'LIKE' , '%'.$request->name.'%');
									}
									if(isset($request->srch_situation) && (!empty($request->srch_situation) || $request->srch_situation == 0))
									{
										$query->where('situation', $request->srch_situation);
									}
								})
								->orderBy('order', 'ASC')
								->paginate($this->perPage);
	}

	public function storeResource($request)
	{
		$dataResource = [
			'name'      => $request->name,
			'order'     => $request->order,
			'situation' => $request->situation, 
		];
		
		$this->resource->create($dataResource);
	}

	public function updateResource($request)
	{
		$dataResource = [
			'name'      => $request->name,
			'order'     => $request->order,
			'situation' => $request->situation, 
		];
		
		$this->resource->where('id', $request->id)
	 			->update($dataResource);
	}
	
	public function getResourceById($id)
	{
		return $this->resource
						->with('permissions')
						->where('id', $id)
						->first();
	}
	
	public function checkName($name, $flow, $id)
	{
		$query =  $this->resource->where('name', $name);
					if($flow == 1)
					{
						$query->where('id', '!=', $id);
					}
		return $query->count();
	}

	public function deleteResources($ids)
	{
		$dels = explode(",", $ids);
		
		foreach ($dels as $del)
		{
			$this->resource->where('id', $del)->delete();
		}
	}
}
