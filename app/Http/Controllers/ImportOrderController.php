<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Http\Requests\ImportOrderRequest;
use App\Services\ImportOrderService;

class ImportOrderController extends Controller
{
	private $configImportService;

	public function __construct(ImportOrderService $configImportService)
	{
		$this->configImportService = $configImportService;
	}
	
	public function index(ImportOrderRequest $request)
	{
		$uploaded = Helpers::handleUploadedFile(auth()->user()->tenant->uuid, $request->file, '');
		
		if (!$uploaded)
		{
			return response()->json(["status" => "0", "message" => "Erro ao fazer upload do Arquivo!"], 400);
		}
		
		$this->configImportService->setImportSpreadsheet($request, $uploaded);
		
		return response()->json(["status" => "1", "message" => "Importação efetuada com sucesso!"]);
	}
}
