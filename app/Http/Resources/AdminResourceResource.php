<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResourceResource extends JsonResource
{
	public function toArray($request)
	{
		return [
			'id'           => $this->id,
			'uuid'         => $this->uuid,
			'resource_id'  => $this->resource_id,
			'name'         => $this->name,
			'permissions'  => AdminPermissionResource::collection($this->permissions),
			'created_at'   => $this->created_at,
			'updated_at'   => $this->updated_at
		];
	}
}