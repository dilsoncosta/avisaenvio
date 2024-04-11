<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
	public function toArray($request)
	{
		return [
			'uuid'                   => $this->uuid,
			'id'                     => $this->id,
			'username'               => $this->username,
			'people'                 => $this->people,
			'name'                   => $this->name,
			'surname'                => $this->surname,
			'corporate_name'         => $this->corporate_name,
			'email'                  => $this->email,
			'phone'                  => $this->phone,
			'whatsapp'               => $this->whatsapp,
			'avatar'                 => $this->avatar,
			'category'               => $this->category,
			'access'                 => $this->access,
			'access'                 => $this->access,
			'ind_mod_order_tracking' => $this->ind_mod_order_tracking,
			'ind_mod_hotel'          => $this->ind_mod_hotel,
			'permissions'            => isset($this->permissions) && count($this->permissions) > 0 ? UserPermissionResource::collection($this->permissions) : [],
			'subdomain'              => $this->subdomain,
			'situation'              => $this->situation,
			'is_admin'               => $this->is_admin,
			'created_at'             => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
			'updated_at'             => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s')
		];
	}
}