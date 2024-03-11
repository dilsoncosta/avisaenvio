<?php 
namespace App\Services;

use App\Helpers\Helpers;
use App\Models\Tenant;

class AccountService
{
	private $tenant;
	
	public function __construct(Tenant $tenant)
	{
		$this->tenant = $tenant;
	}
	
	public function getAllAccountByTenantId()
	{
		return $this->tenant->where('id', auth()->user()->tenant->id)->first();
	}
	
	public function updateAccount($request)
	{
		$uploadedCertificate         = null;
		$uploadedLogoPortal          = null;
		$tenant_id                   = auth()->user()->tenant->id;
		$tenant_uuid                 = auth()->user()->tenant->uuid;
		$tenant_filename_certificate = auth()->user()->tenant->filename_certificate;
		$tenant_file_certificate     = auth()->user()->tenant->file_certificate;
		$tenant_filename_logo_portal = auth()->user()->tenant->tenant_filename_logo_portal;
		$tenant_file_logo_portal     = auth()->user()->tenant->tenant_file_logo_portal;
		
		if ($request->hasFile('certificate') && $request->certificate->isValid())
		{
			$uploadedCertificate = Helpers::handleUploadedFile($tenant_uuid.'/certificate', $request->certificate, $tenant_file_certificate);
			
			if ($uploadedCertificate === false)
			{
				return response()->json(array( "status" => "0", "message" => "Erro ao fazer upload do Certificado!" ), 400);
			}
		}
		
		if($uploadedCertificate)
		{
			$this->tenant->where('id', $tenant_id)->update([
				'filename_certificate' => $uploadedCertificate->name,
				'file_certificate'     => $uploadedCertificate->path
			]);
		}
		
		if($request->hasFile('logo_portal') && $request->logo_portal->isValid())
		{
			$uploadedLogoPortal = Helpers::handleUploadedFile($tenant_uuid, $request->logo_portal, $tenant_filename_logo_portal);
			
			if ($uploadedLogoPortal === false)
			{
				return response()->json(array( "status" => "0", "message" => "Erro ao fazer upload da Logo do Portal!" ), 400);
			}
		}
		
		if($uploadedLogoPortal)
		{
			$this->tenant->where('id', $tenant_id)->update([
				'filename_logo_portal' => $uploadedLogoPortal->name,
				'file_logo_portal'     => $uploadedLogoPortal->path
			]);
		}
		
		$this->tenant->where('id', $tenant_id)->update([
			'color_general' => $request->color_general
		]);
	}
	
	public function deleteCertificate($tenant)
	{
		Helpers::deleteFile($tenant->file_certificate);
		$tenant->update([
			'filename_certificate' => '',
			'file_certificate'     => ''
		]);
	}
	
	public function deleteLogoPortal($tenant)
	{
		Helpers::deleteFile($tenant->file_logo_portal);
		$tenant->update([
			'filename_logo_portal' => '',
			'file_logo_portal'     => ''
		]);
	}
}
