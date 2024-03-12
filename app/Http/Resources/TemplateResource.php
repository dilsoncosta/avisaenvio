<?php

namespace App\Http\Resources;

use App\Helpers\Helpers;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TemplateResource extends JsonResource
{
	public function toArray($request)
	{
		return [
			'uuid'                  => $this->uuid,
			'id'                    => $this->id,
			'type'                  => $this->type,
			'title'                 => $this->title,
			'message'               => str_replace("<br/>", "\n", $this->message),
			'situation'             => $this->situation,
			'filename_1'            => $this->filename_1,
			'file_1'                => $this->file_1,
			'ext_1'                 => $this->ext_1,
			'size_1'                => $this->size_1,
			'filename_2'            => $this->filename_2,
			'file_2'                => $this->file_2,
			'ext_2'                 => $this->ext_2,
			'size_2'                => $this->size_2,
			'filename_3'            => $this->filename_3,
			'file_3'                => $this->file_3,
			'ext_3'                 => $this->ext_3,
			'size_3'                => $this->size_3,
			'created_at'            => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
			'updated_at'            => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s')
		];
	}
}