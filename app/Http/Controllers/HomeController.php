<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
	Order,
	Collaborator
};

class HomeController extends Controller
{
	private $order;
	private $collaborator;
	
	public function __construct(
		Order $order,
		Collaborator $collaborator
	)
	{
		$this->order = $order;
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
			'order'                     => $this->getTotalOrder(),
			'config_total_collaborator' => $this->getConfigTotalCollaborators(),
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
}