<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use App\Helpers\Helpers;
use App\Models\{
	Template
};
use App\Jobs\{
	CrmSendWhatsAppNowJob
};

class TemplateService
{
	private $template;
	private $perPage = 20;
	
	public function __construct(Template $template)
	{
		$this->template = $template;
	}
	
	public function getAllTemplates($request)
	{
		return $this->template
								->where(function($query) use ($request)
								{
									if(isset($request->srch_type) && (!empty($request->srch_type) || $request->srch_type == 0))
									{
										$query->where('type', $request->srch_type);
									}
									if(isset($request->srch_title) && !empty($request->srch_title))
									{
										$query->where('title', 'LIKE' , '%'.$request->srch_title.'%');
									}
									if(isset($request->srch_situation) && (!empty($request->srch_situation) || $request->srch_situation == 0))
									{
										$query->where('situation', $request->srch_situation);
									}
								})
								->orderBy('id', 'DESC')
								->paginate($this->perPage);
	}
	
	public function storeTemplate($request)
	{
		$dataTemplate = [
			'crm_business_id' => $request->business_id, 
			'type'            => $request->type, 
			'title'           => $request->title, 
			'message'         => $request->message, 
			'situation'       => $request->situation, 
		];
		
		if($request->hasFile('file_1') && $request->file('file_1')->isValid())
		{
			$uploadedFile = Helpers::handleUploadedFile(auth()->user()->tenant->uuid, $request->file_1, '');
			
			if ($uploadedFile === false)
			{
				return false;
			}
			
			$filename_storage = explode('/',$uploadedFile->path);
			$dataCrmTemplate['filename_1']         = $request->file_1->getClientOriginalName();
			$dataCrmTemplate['filename_storage_1'] = $filename_storage[1];
			$dataCrmTemplate['file_1']             = $uploadedFile->path;
			$dataCrmTemplate['ext_1']              = $uploadedFile->ext;
			$dataCrmTemplate['size_1']             = $uploadedFile->size;
		}
		
		if($request->hasFile('file_2') && $request->file('file_2')->isValid())
		{
			$uploadedFile = Helpers::handleUploadedFile(auth()->user()->tenant->uuid, $request->file_2, '');
			
			if ($uploadedFile === false)
			{
				return false;
			}
			
			$filename_storage = explode('/',$uploadedFile->path);
			
			$dataCrmTemplate['filename_2']         = $request->file_2->getClientOriginalName();
			$dataCrmTemplate['filename_storage_2'] = $filename_storage[1];
			$dataCrmTemplate['file_2']             = $uploadedFile->path;
			$dataCrmTemplate['ext_2']              = $uploadedFile->ext;
			$dataCrmTemplate['size_2']             = $uploadedFile->size;
		}
		
		if($request->hasFile('file_3') && $request->file('file_3')->isValid())
		{
			$uploadedFile = Helpers::handleUploadedFile(auth()->user()->tenant->uuid, $request->file_3, '');
			
			if ($uploadedFile === false)
			{
				return false;
			}
			
			$filename_storage = explode('/',$uploadedFile->path);
			
			$dataCrmTemplate['filename_3']         = $request->file_3->getClientOriginalName();
			$dataCrmTemplate['filename_storage_3'] = $filename_storage[1];
			$dataCrmTemplate['file_3']             = $uploadedFile->path;
			$dataCrmTemplate['ext_3']              = $uploadedFile->ext;
			$dataCrmTemplate['size_3']             = $uploadedFile->size;
		}
		
		$this->template->create($dataTemplate);
	}
	
	public function updateTemplate($request)
	{
		$dataCrmTemplate = [
			'type'      => $request->type, 
			'title'     => $request->title, 
			'message'   => $request->message,
			'situation' => $request->situation, 
		];
		
		if($request->hasFile('file_1') && $request->file('file_1')->isValid())
		{
			$uploadedFile = Helpers::handleUploadedFile(auth()->user()->tenant->uuid, $request->file_1, '');
			
			if ($uploadedFile === false)
			{
				return false;
			}
			
			$filename_storage = explode('/',$uploadedFile->path);
			
			$dataCrmTemplate['filename_1']         = $request->file_1->getClientOriginalName();
			$dataCrmTemplate['filename_storage_1'] = $filename_storage[1];
			$dataCrmTemplate['file_1']             = $uploadedFile->path;
			$dataCrmTemplate['ext_1']              = $uploadedFile->ext;
			$dataCrmTemplate['size_1']             = $uploadedFile->size;
		}
		
		if($request->hasFile('file_2') && $request->file('file_2')->isValid())
		{
			$uploadedFile = Helpers::handleUploadedFile(auth()->user()->tenant->uuid, $request->file_2, '');
			
			if ($uploadedFile === false)
			{
				return false;
			}
			
			$filename_storage = explode('/',$uploadedFile->path);
			
			$dataCrmTemplate['filename_2']         = $request->file_2->getClientOriginalName();
			$dataCrmTemplate['filename_storage_2'] = $filename_storage[1];
			$dataCrmTemplate['file_2']             = $uploadedFile->path;
			$dataCrmTemplate['ext_2']              = $uploadedFile->ext;
			$dataCrmTemplate['size_2']             = $uploadedFile->size;
		}
		
		if($request->hasFile('file_3') && $request->file('file_3')->isValid())
		{
			$uploadedFile = Helpers::handleUploadedFile(auth()->user()->tenant->uuid, $request->file_3, '');
			
			if ($uploadedFile === false)
			{
				return false;
			}
			
			$filename_storage = explode('/',$uploadedFile->path);
			
			$dataCrmTemplate['filename_3']         = $request->file_3->getClientOriginalName();
			$dataCrmTemplate['filename_storage_3'] = $filename_storage[1];
			$dataCrmTemplate['file_3']             = $uploadedFile->path;
			$dataCrmTemplate['ext_3']              = $uploadedFile->ext;
			$dataCrmTemplate['size_3']             = $uploadedFile->size;
		}
		
		$this->template->where('id', $request->id)->update($dataCrmTemplate);
	}
	
	public function deleteTemplates($ids)
	{
		$dels = explode(",",$ids);
		
		foreach($dels as $del)
		{
			$template = $this->getTemplateById($del);
			
			if($template->file_1)
			{
				if(Storage::exists($template->file_1))
				{
					Storage::delete($template->file_1);
				}
			}
			
			if($template->file_2)
			{
				if(Storage::exists($template->file_2))
				{
					Storage::delete($template->file_2);
				}
			}
			
			if($template->file_3)
			{
				if(Storage::exists($template->file_3))
				{
					Storage::delete($template->file_3);
				}
			}
			
			$template->where('id', $del)
							->delete();
		}
	}
	
	public function deleteFileTemplates($template, $request)
	{
		switch ($request->type) {
			case '0':
				$file = $template->file_1;
				$this->template->where('id', $request->id)
														->update([
															'file_1'             => '',
															'filename_storage_1' => '',
															'filename_1'         => '',
															'ext_1'              => '',
															'size_1'             => '',
														]);
				break;
			case '1':
				$file = $template->file_2;
				$this->template->where('id', $request->id)
														->update([
															'file_2'             => '',
															'filename_storage_2' => '',
															'filename_2'         => '',
															'ext_2'              => '',
															'size_2'             => '',
														]);
				break;
			case '2':
				$file = $template->file_3;
				$this->template->where('id', $request->id)
														->update([
															'file_3'             => '',
															'filename_storage_3' => '',
															'filename_3'         => '',
															'ext_3'              => '',
															'size_3'             => '',
														]);
				break;
			default:
				return;
				break;
		}
		
		Helpers::deleteFile($file);
	}
	
	public function sendWhatsAppTemplate($template)
	{
		$obj_data = (object) array(
			'tenant_id'                => $template->tenant_id,
			'ind_integration_whatsapp' => 0,
			'business_id'              => $template->crm_business_id,
			'contact_id'               => 0,
			'name'                     => ucfirst(strtolower(auth()->user()->name)) . ' ' . ucfirst(strtolower(auth()->user()->surname)),
			'email'                    => auth()->user()->email,
			'phone'                    => Helpers::formata_telefone(auth()->user()->phone),
			'whatsapp'                 => auth()->user()->whatsapp ? auth()->user()->whatsapp : auth()->user()->phone,
			'whatsapp_format'          => Helpers::formata_telefone(auth()->user()->whatsapp),
			'template_id'              => $template->id,
			'message'                  => $template->message,
			'file_1'                   => $template->file_1,
			'filename_1'               => $template->filename_1,
			'file_2'                   => $template->file_2,
			'filename_2'               => $template->filename_2,
			'file_3'                   => $template->file_3,
			'filename_3'               => $template->filename_3,
			'send_to'                  => 'Sistema',
		);
		CrmSendWhatsAppNowJob::dispatch($obj_data);
	}
	
	public function getTemplateById($id)
	{
		return $this->template
							->where('id', $id)
							->first();
	}

	public function getExistedTemplate($id, $flow, $type)
	{
		$query =  $this->template->where('type', $type)
							->where('situation', 1);
							if($flow == 1)
							{
								$query->where('id', "!=",$id);
							}
		return $query->exists();
	}
}
