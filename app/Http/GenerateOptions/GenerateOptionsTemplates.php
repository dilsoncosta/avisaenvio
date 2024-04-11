<?php

namespace App\Http\GenerateOptions;

use Illuminate\Http\Request;
use App\Http\Resources\{
	TemplateResource
};
use App\Models\{
	Template
};

class GenerateOptionsTemplates
{
	private $model_template;
	
	public function __construct(
		Template $template
	)
	{
		$this->model_template = $template;
	}
	
	public function index(Request $request)
	{
		$templates = $this->model_template
										->where('situation', 1)
										->orderBy('id', 'DESC')
										->get();
		
		if (!count((is_countable($templates) ? $templates : [])))
		{
			return response()->json(array("status" => "0", "message" => "Nenhum registro encontrado!"), 404);
		}
		
		return response()->json(array("status" => "1", "message" => "", "data" => TemplateResource::collection($templates)));
	}
}