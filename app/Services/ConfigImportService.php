<?php 
namespace App\Services;

use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\{
	Tracking,
};
use Illuminate\Support\Facades\Log;

class ConfigImportService
{
	private $tracking;

	public function __construct(Tracking $tracking)
	{
		$this->tracking = $tracking;
	}
	
	public function setImportSpreadsheet($uploaded)
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
				if(empty($item[1]))
				{
					continue;
				}
				if(empty($item[19]))
				{
					continue;
				}
				if(empty($item[42]))
				{
					continue;
				}

				if($this->getExistedContact($item[1]) > 0)
				{
					continue;
				}
				
				$this->tracking->create([
					'destination' => $item[19],
					'whatsapp'    => $item[42],
					'object'      => $item[1],
					'situation'   => '0', 
				]);
			}
		}
		
		if (Storage::exists($uploaded->path))
		{
			Storage::delete($uploaded->path);
		}
	}
	
	private function getExistedContact($object)
	{
		return $this->tracking->where('object', $object)->count();
	}
}
