<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\OrderResource;
use App\Http\Requests\OrderRequest;
use App\Services\OrderService;

class OrderController extends Controller
{
	private $orderService;

	public function __construct(OrderService $orderService)
	{
		$this->orderService = $orderService;
	}
	
	public function index(Request $request)
	{
		$orders = $this->orderService->getAllOrders($request);
		
		if ($orders->isEmpty())
		{
			return response()->json(["status" => "0", "message" => "Nenhum registro encontrado!"], 404);
		}
		
		return response()->json(array("status" => "1", "message" => "", "data" => OrderResource::collection($orders)->response()->getData(false)));
	}

	public function store(OrderRequest $request)
	{
		if($this->orderService->getExistedObject($request->object, $request->type_integration, 0, ''))
		{
			return response()->json(array("status" => "1", "message" => "OBJETO já cadastrado para a INTEGRAÇÃO selecionada!"), 400);
		}
		
		$this->orderService->storeOrder($request);
		
		return response()->json(array("status" => "1", "message" => "Cadastro Efetuado com Sucesso!"));
	}
	
	public function update(OrderRequest $request)
	{
		$order = $this->orderService->getOrderById($request->id);
		
		if(!$order)
		{
			return response()->json(array("status" => "0", "message" => "Incapaz de realizar a listagem. Registro inexistente!"), 404);
		}
		
		if($this->orderService->getExistedObject($request->object, $request->type_integration,1, $request->id))
		{
			return response()->json(array("status" => "1", "message" => "OBJETO já cadastrado para a INTEGRAÇÃO selecionada!"), 400);
		}
		
		$this->orderService->updateOrder($request);
		
		return response()->json(array("status" => "1", "message" => "Registro Atualizado com Sucesso!"));
	}
	
	public function show(Request $request)
	{
		$business = $this->orderService->getOrderById($request->id);
		
		if(!$business)
		{
			return response()->json(array("status" => "0", "message" => "Incapaz de realizar a listagem. Registro inexistente!"), 404);
		}
		
		return response()->json(array("status" => "1", "message" => "", "data" => new OrderResource($business)));
	}
	
	public function destroy(Request $request)
	{
		$this->orderService->deleteOrders($request->ids);
		return response()->json(array("status" => "1", "message" => "Registro deletado com sucesso!"));
	}
}
