<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
	Order,
	Collaborator,
	Hospitality
};

class HomeController extends Controller
{
	private $order;
	private $collaborator;
	private $hospitality;
	
	public function __construct(
		Order $order,
		Collaborator $collaborator,
		Hospitality $hospitality
	)
	{
		$this->order = $order;
		$this->collaborator = $collaborator;
		$this->hospitality = $hospitality;
	}

	public function index(Request $request)
	{
		$data = $this->getData();
		
		return response()->json(['status' => '1', 'message' => '', 'data' => $data]);
	}
	
	private function getData()
	{
		$data = [
			'order'                      => $this->getTotalOrder(),
			'config_total_collaborator'  => $this->getConfigTotalCollaborators(),
			'config_total_hospitalities' => $this->getConfigTotalHospitalities(),
		];
		
		return $data;
	}
	
	private function getTotalOrder()
	{
		return $this->order->count();
	}

	private function getConfigTotalCollaborators()
	{
		return $this->collaborator->count();
	}
	
	private function getConfigTotalHospitalities()
	{
		return $this->hospitality->count();
	}
}