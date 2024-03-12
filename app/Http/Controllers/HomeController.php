<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
	Tracking,
	Collaborator
};

class HomeController extends Controller
{
	private $tracking;
	private $collaborator;
	
	public function __construct(
		Tracking $tracking,
		Collaborator $collaborator
	)
	{
		$this->tracking = $tracking;
		$this->collaborator = $collaborator;
	}

	public function index(Request $request)
	{
		$data = $this->getData();
		
		return response()->json(['status' => '1', 'message' => '', 'data' => $data]);
	}
	
	private function getData()
	{
		$data = [
			'tracking'                  => $this->getTotalTracking(),
			'config_total_collaborator' => $this->getConfigTotalCollaborators(),
		];
		
		return $data;
	}
	
	private function getTotalTracking()
	{
		return $this->tracking->count();
	}

	private function getConfigTotalCollaborators()
	{
		return $this->collaborator->count();
	}
}