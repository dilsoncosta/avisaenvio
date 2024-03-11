<?php

namespace App\Http\Resources;

use App\Helpers\Helpers;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
{
	public function toArray($request)
	{
		return [
			'uuid'                      => $this->uuid,
			'id'                        => $this->id,
			'filename_certificate'      => $this->filename_certificate,
			'file_certificate'          => $this->file_certificate,
			'filename_logo_portal'      => $this->filename_logo_portal,
			'file_logo_portal'          => $this->file_logo_portal,
			'color_general'             => $this->color_general,
			'created_at'                => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
			'updated_at'                => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s'),
		];
	}
}