<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\TenantResource;
use Illuminate\Http\Request;
use App\Models\{
	PortalInformative,
	PortalChecklist,
	PortalTraining,
	PortalMaterial,
	Collaborator,
	PortalFranchise,
	CrmContactEvent,
	CrmContactTask,
	CrmSeller,
	CrmMessage,
	CrmContact
};
use App\Http\Resources\{
	PortalInformativeResource,
	PortalTrainingResource
};
use Carbon\Carbon;

class HomeController extends Controller
{
	private $portalInformative;
	private $portalChecklist;
	private $portalTraining;
	private $portalMaterial;
	private $collaborator;
	private $portalFranchise;
	private $crmContactEvent;
	private $crmContactTask;
	private $crmSeller;
	private $crmMessage;
	private $crmContact;
	
	public function __construct(
		PortalInformative $portalInformative,
		PortalChecklist $portalChecklist,
		PortalTraining $portalTraining,
		PortalMaterial $portalMaterial,
		Collaborator $collaborator,
		PortalFranchise $portalFranchise,
		CrmContactEvent $crmContactEvent,
		CrmContactTask $crmContactTask,
		CrmSeller $crmSeller,
		CrmMessage $crmMessage,
		CrmContact $crmContact
	)
	{
		$this->portalInformative = $portalInformative;
		$this->portalChecklist = $portalChecklist;
		$this->portalTraining = $portalTraining;
		$this->portalMaterial = $portalMaterial;
		$this->collaborator = $collaborator;
		$this->portalFranchise = $portalFranchise;
		$this->crmContactEvent = $crmContactEvent;
		$this->crmContactTask = $crmContactTask;
		$this->crmSeller = $crmSeller;
		$this->crmMessage = $crmMessage;
		$this->crmContact = $crmContact;
	}

	public function index(Request $request)
	{
		$flow = $request->flow;
		
		if ($flow != 0 && $flow != 1)
		{
			return response()->json(['status' => '0', 'message' => 'Fluxo Indefinido!'], 400);
		}
		
		$data = $this->getData($flow);
		
		return response()->json(['status' => '1', 'message' => '', 'data' => $data]);
	}
	
	private function getData($flow)
	{
		$data = [
			'portal_total_informative'  => $this->getPortalTotalInformative($flow),
			'portal_total_checklist'    => $this->getPortalTotalChecklists($flow),
			'portal_total_training'     => $this->getPortalTotalTrainings($flow),
			'portal_total_marketing'    => $this->getPortalTotalMarketings($flow),
			'portal_total_manual'       => $this->getPortalTotalManuals($flow),
			'portal_total_franchise'    => $this->getPortalTotalFranchises(),
			'portal_last_informative'   => $this->getPortalLastsInformatives(),
			'portal_last_training'      => $this->getPortalLastsTrainings(),
			'config_total_collaborator' => $this->getConfigTotalCollaborators(),
			'crm_total_event'           => $this->getCrmTotalEvents(),
			'crm_total_task'            => $this->getCrmTotalTasks(),
			'crm_total_seller'          => $this->getCrmTotalSellers(),
			'crm_total_contact'         => $this->getCrmTotalContacts(),
			'crm_total_message'         => $this->getCrmTotalMessages(),
		];
		
		return $data;
	}
	
	private function getPortalTotalInformative($flow)
	{
		if ($flow === 0)
		{
			return $this->portalInformative->count();
		}
		else
		{
			return $this->portalInformative
					->where('datetime_start', '<=', Carbon::now())
					->where('datetime_end', '>=', Carbon::now())
					->where('situation', 1)
					->count();
		}
	}

	private function getPortalTotalChecklists($flow)
	{
		return $this->portalChecklist
				->where('situation', $flow === 0 ? 0 : 1)
				->count();
	}
	
	private function getPortalTotalTrainings($flow)
	{
		return $this->portalTraining
				->when($flow === 0, function ($query) {
						return $query->where('situation', 1);
				})
				->when($flow !== 0, function ($query) use ($flow) {
						return $query->whereHas('segmentations', function ($query) use ($flow) {
								if (!empty($flow)) {
										$query->whereIn('portal_segmentation_id', explode(',', $flow));
								}
						})->where('situation', 1);
				})
				->count();
	}
	
	private function getPortalTotalMarketings($flow)
	{
		return $this->portalMaterial
				->where('type', 1)
				->when($flow === 0, function ($query) {
						return $query->where('situation', 1);
				})
				->count();
	}

	private function getPortalTotalManuals($flow)
	{
		return $this->portalMaterial
				->where('type', 0)
				->when($flow === 0, function ($query) {
						return $query->where('situation', 1);
				})
				->count();
	}
	
	private function getPortalLastsInformatives()
	{
			return PortalInformativeResource::collection(
					$this->portalInformative
							->where('datetime_start', '<=', Carbon::now())
							->where('datetime_end', '>=', Carbon::now())
							->limit(5)
							->where('situation', 1)
							->orderBy('id', 'desc')
							->get()
			)->response()->getData(false);
	}
	
	private function getPortalLastsTrainings()
	{
		return PortalTrainingResource::collection(
				$this->portalTraining
						->limit(5)
						->where('situation', 1)
						->orderBy('id', 'desc')
						->get()
		)->response()->getData(false);
	}
	
	private function getConfigTotalCollaborators()
	{
		return $this->collaborator->count();
	}
	
	private function getPortalTotalFranchises()
	{
		return $this->portalFranchise->count();
	}
	
	private function getCrmTotalEvents()
	{
		if(auth()->user()->category == 'CLB')
		{
			return $this->crmContactEvent->where('collaborator_id', auth()->user()->collaborator->id)->count();
		}
		return $this->crmContactEvent->count();
	}
	
	private function getCrmTotalTasks()
	{
		if(auth()->user()->category == 'CLB')
		{
			return $this->crmContactTask->where('collaborator_id', auth()->user()->collaborator->id)->count();
		}
		return $this->crmContactTask->count();
	}
	
	private function getCrmTotalSellers()
	{
		return $this->crmSeller->count();
	}
	
	private function getCrmTotalContacts()
	{
		$query = $this->crmContact->with(['seller']);
						if(auth()->user()->category == 'CLB')
						{
							$query->whereHas('seller', function($query)
							{
								$query->where('collaborator_id', auth()->user()->collaborator->id);
							});
						}
			return $query->count();
	}
	
	private function getCrmTotalMessages()
	{
		$query = $this->crmMessage->with(['contact.seller']);
		if(auth()->user()->category == 'CLB')
		{
			$query->whereHas('contact.seller', function($query)
			{
				$query->where('collaborator_id', auth()->user()->collaborator->id);
			});
		}
		$query->where('crm_contact_id', '!=', '0');
		
		return $query->count();
	}
}