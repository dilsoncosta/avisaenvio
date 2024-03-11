<?php

namespace App\Http\Resources;

use App\Helpers\Helpers;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CollaboratorResource extends JsonResource
{
	public function toArray($request)
	{
		return [ 
			'uuid'        => $this->uuid,
			'id'          => $this->id,
			'collaborator_type' => $this->collaborator_type,
			'user'        => new UserResource($this->user),
			'permissions' => AdminPermissionResource::collection($this->permissions),
			'created_at'  => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
			'updated_at'  => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s')
		];
	}
}