<?php
namespace App\Services;

use App\Models\{
	Order,
	OrderEvent
};

class OrderService
{
	private $order;
	private $orderEvent;
	private $perPage = 20;
	
	public function __construct(Order $order, OrderEvent $orderEvent)
	{
		$this->order = $order;
		$this->orderEvent = $orderEvent;
	}
	
	public function getAllOrders($request)
	{
		return $this->order
								->with(['orderEvents'])
								->where(function($query) use ($request)
								{
									if(isset($request->srch_code) && !empty($request->srch_code))
									{
										$query->where('code', 'LIKE', '%'.$request->srch_code.'%');
									}
									if(isset($request->srch_destination) && !empty($request->srch_destination))
									{
										$query->where('destination', 'LIKE', '%'.$request->srch_destination.'%');
									}
									if(isset($request->srch_object) && !empty($request->srch_object))
									{
										$query->where('object', 'LIKE', '%'.$request->srch_object.'%');
									}
									if(isset($request->srch_situation) && (!empty($request->srch_situation) || $request->srch_situation == 0))
									{
										$query->where('last_situation', $request->srch_situation);
									}
								})
								->orderBy('id', 'DESC')
								->paginate($this->perPage);
	}
	
	public function storeOrder($request)
	{
		$dataOrder = [
			'code'             => $request->code, 
			'destination'      => $request->destination, 
			'whatsapp'         => $request->whatsapp, 
			'cpf_cnpj'         => $request->cpf_cnpj, 
			'object'           => $request->object, 
			'integration'      => 1,
			'shipping_company' => $request->shipping_company,
			'last_situation'   => 0, 
		];
		
		$this->order->create($dataOrder);
	}
	
	public function updateOrder($request)
	{
		$dataOrder = [
			'code'             => $request->code, 
			'destination'      => $request->destination, 
			'whatsapp'         => $request->whatsapp, 
			'cpf_cnpj'         => $request->cpf_cnpj, 
			'object'           => $request->object, 
			'integration'      => 1,
			'shipping_company' => $request->shipping_company,
			'last_situation'   => 0, 
		];
		
		$this->order->where('id', $request->id)->update($dataOrder);
	}
	
	public function getOrderById($id)
	{
		return $this->order
								->with(['orderEvents'])
								->where('id', $id)
								->first();
	}

	public function deleteOrders($ids)
	{
		$dels = explode(",",$ids);

		foreach($dels as $del)
		{
			$this->orderEvent->where('order_id', $del)
					->delete();
			
			$this->order->where('id', $del)
					->delete();
		}
	}
	
	public function getExistedObject($object, $shipping_company, $flow, $id)
	{
		$query = $this->order->where('object', $object)
			->where('shipping_company', $shipping_company);
			if($flow == 1)
			{
				$query->where('id', '!=', $id);
			}
			return $query->exists();
	}
	
	public function getExistedCode($code, $shipping_company, $flow, $id)
	{
		$query = $this->order->where('code', $code)
			->where('shipping_company', $shipping_company);
			if($flow == 1)
			{
				$query->where('id', '!=', $id);
			}
			return $query->exists();
	}
}
