<?php 
namespace App\Services;

use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\{
	Order,
};

class ImportOrderService
{
	private $order;

	public function __construct(Order $order)
	{
		$this->order = $order;
	}
	
	public function setImportSpreadsheet($request, $uploaded)
	{
		$path_file = Storage::disk('public')->path($uploaded->path);
		
		try
		{
			$spreadsheet = IOFactory::load($path_file);
		}
		catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e)
		{
			return false;
		}
		
		$worksheet = $spreadsheet->getActiveSheet();
		$data = [];
		
		foreach ($worksheet->getRowIterator() as $row)
		{
			$rowData = [];
			
			foreach ($row->getCellIterator() as $cell)
			{
				$rowData[] = $cell->getValue();
			}
			$data[] = $rowData;
		}
		
		$data = array_filter($data);
		
		foreach($data as $key => $item)
		{
			
			if($key > 0)
			{
				if(empty($item[0]) || empty($item[1]) || empty($item[2]) || empty($item[3]))
				{
					continue;
				}
				
				if($this->getExistedOrder($item[3], $request->shipping_company) > 0)
				{
					continue;
				}
				
				$this->order->create([
					'code'             => $item[2],
					'destination'      => $item[0],
					'whatsapp'         => $item[1],
					'object'           => $item[3],
					'integration'      => 1,
					'shipping_company' => $request->shipping_company,
					'situation'        => '0', 
				]);
			}
		}
		
		if (Storage::exists($uploaded->path))
		{
			Storage::delete($uploaded->path);
		}
	}
	
	private function getExistedOrder($object, $shipping_company)
	{
		return $this->order->where('object', $object)
							->where('shipping_company', $shipping_company)
							->count();
	}
}
