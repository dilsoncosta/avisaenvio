<?php

namespace App\Http\GenerateOptions;

use Illuminate\Http\Request;
use App\Http\Resources\{
	CollaboratorResource
};
use App\Models\{
	Collaborator,
};
use DB;
use Illuminate\Support\Facades\Http;

class GenerateOptionsCollaborators
{
  private $model_collaborator;
	
	public function __construct(
		Collaborator $collaborator
	)
	{
		$this->model_collaborator = $collaborator;
	}
	
	public function index(Request $request)
	{
		$collaborators = $this->model_collaborator->with('user')
										->whereHas('user', function($query) use($request)
										{
											$query->where('situation', 1);
										})
										->orderBy('id', 'DESC')
										->get();
		
		if (!count((is_countable($collaborators) ? $collaborators : [])))
		{
			return response()->json(array("status" => "0", "message" => "Nenhum registro encontrado!"), 404);
		}
		
		return response()->json(array("status" => "1", "message" => "", "data" => CollaboratorResource::collection($collaborators)));
	}
}