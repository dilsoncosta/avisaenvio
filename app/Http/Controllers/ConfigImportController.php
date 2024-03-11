<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Http\Requests\ConfigImportRequest;
use App\Services\ConfigImportService;

class ConfigImportController extends Controller
{
	private $configImportService;

	public function __construct(ConfigImportService $configImportService)
	{
		$this->configImportService = $configImportService;
	}
	
	public function index(ConfigImportRequest $request)
	{
		$uploaded = Helpers::handleUploadedFile(auth()->user()->tenant->uuid, $request->file, '');
		
		if (!$uploaded)
		{
			return response()->json(["status" => "0", "message" => "Erro ao fazer upload do Arquivo!"], 400);
		}
		
		$this->configImportService->setImportSpreadsheet($uploaded);
		
		return response()->json(["status" => "1", "message" => "Importação efetuada com sucesso!"]);
	}
}
