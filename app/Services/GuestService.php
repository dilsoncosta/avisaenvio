<?php
namespace App\Services;

use App\Models\{
	Guest,
	Hospitality
};

class GuestService
{
	private $guest;
	private $hospitality;
	private $perPage = 20;
	
	public function __construct(Guest $guest, Hospitality $hospitality)
	{
		$this->guest = $guest;
		$this->hospitality = $hospitality;
	}
	
	public function getAllGuests($request)
	{
		return $this->guest
								->with(['msgOneTemplate', 'msgTwoTemplate', 'msgThreeTemplate', 'msgFourTemplate', 'msgFiveTemplate', 'msgSixTemplate'])
								->where(function($query) use ($request)
								{
									if(isset($request->srch_date_checkin) && !empty($request->srch_date_checkin))
									{
										$query->whereDate('date_checkin', '>=', $request->srch_date_checkin);
									}
									if(isset($request->srch_date_checkout) && !empty($request->srch_date_checkout))
									{
										$query->whereDate('date_checkout', '<=', $request->srch_date_checkout);
									}
									if(isset($request->srch_name_surname) && !empty($request->srch_name_surname))
									{
										$query->where('name_surname', 'LIKE', '%'.$request->srch_name_surname.'%');
									}
									if(isset($request->srch_whatsapp) && !empty($request->srch_whatsapp))
									{
										$query->where('whatsapp', 'LIKE', '%'.$request->srch_whatsapp.'%');
									}
									if(isset($request->srch_situation) && (!empty($request->srch_situation) || $request->srch_situation == 0))
									{
										$query->where('situation', $request->srch_situation);
									}
								})
								->orderBy('id', 'DESC')
								->paginate($this->perPage);
	}
	
	public function storeGuest($request)
	{
		$dataGuest = [
			'hospitality_id' => $this->getHospitality()->id,
			'name_surname'   => $request->name_surname,
			'whatsapp'       => $request->whatsapp, 
			'date_checkin'   => $request->date_checkin, 
			'date_checkout'  => $request->date_checkout, 
			'situation'      => $request->situation,
		];
		
		$this->guest->create($dataGuest);
	}
	
	public function updateGuest($request)
	{
		$dataOrder = [
			'name_surname'      => $request->name_surname,
			'whatsapp'          => $request->whatsapp, 
			'date_checkin'      => $request->date_checkin, 
			'date_checkout'     => $request->date_checkout, 
			'situation'         => $request->situation,
		];
		
		$this->guest->where('id', $request->id)->update($dataOrder);
	}
	
	public function getGuestById($id)
	{
		return $this->guest
								->where('id', $id)
								->first();
	}

	public function deleteGuests($ids)
	{
		$dels = explode(",",$ids);

		foreach($dels as $del)
		{
			$this->guest->where('id', $del)
					->delete();
		}
	}
	
	public function getExistedGuest($request, $flow, $id)
	{
		$query = $this->guest->where('whatsapp', $request->whatsapp)
			->where('date_checkin', $request->date_checkin)
			->where('date_checkout', $request->date_checkout);
			if($flow == 1)
			{
				$query->where('id', '!=', $id);
			}
			return $query->exists();
	}

	public function getHospitality()
	{
		return $this->hospitality->first();
	}
}
