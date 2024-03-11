<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminPermissionResource extends JsonResource
{
	public function toArray($request)
	{
		return [
			'id'           => $this->id,
			'uuid'         => $this->uuid,
			'resource'     => $this->permission_resource,
			'name'         => $this->name,
			'order'        => $this->order,
			'created_at'   => $this->created_at,
			'updated_at'   => $this->updated_at
		];
	}
}