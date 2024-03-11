<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserPermissionResource extends JsonResource
{
	public function toArray($request)
	{
		return [
			'name' => $this->name,
		];
	}
}