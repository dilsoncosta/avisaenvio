<?php
namespace App\Services;

use App\Models\{
	Tracking,
	TrackingEvent
};

class TrackingService
{
	private $tracking;
	private $trackingEvent;
	private $perPage = 20;
	
	public function __construct(Tracking $tracking, TrackingEvent $trackingEvent)
	{
		$this->tracking = $tracking;
		$this->trackingEvent = $trackingEvent;
	}
	
	public function getAllTrackings($request)
	{
		return $this->tracking
								->with(['trackingEvents'])
								->where(function($query) use ($request)
								{
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
										$query->where('situation', $request->srch_situation);
									}
								})
								->orderBy('id', 'DESC')
								->paginate($this->perPage);
	}
	
	public function getTrackingById($id)
	{
		return $this->tracking
								->with(['trackingEvents'])
								->where('id', $id)
								->first();
	}

	public function deleteTrackings($ids)
	{
		$dels = explode(",",$ids);

		foreach($dels as $del)
		{
			$this->trackingEvent->where('tracking_id', $del)
					->delete();
			
			$this->tracking->where('id', $del)
					->delete();
		}
	}
}
