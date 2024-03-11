<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest as RequestsRegisterRequest;
use App\Jobs\ConfirmedRegisterClientJob;
use App\Jobs\RegisterClientJob;
use App\Models\{
	User,
	Tenant,
	Access
};
use Carbon\Carbon;
use Illuminate\Http\Request;
use stdClass;

class RegisterController extends Controller
{
	private $model_user;
	private $model_tenant;
	private $model_access;
	private $model_crm_seller;
	
	public function __construct(User $user, 
	Tenant $tenant, 
	Access $access,
	)
	{
		$this->model_user       = $user;
		$this->model_tenant     = $tenant;
		$this->model_access     = $access;
	}
	
	public function store(RequestsRegisterRequest $request)
	{
		$checkSubdomain = $this->model_tenant->where('subdomain', $request->subdomain)->count();
		
		if($checkSubdomain > 0)
		{
			return response()->json(['status'  => 0, 'message' => 'SUBDOMINIO já cadastrado!'], 404);
		}
		
		$tenant = $this->model_tenant->create([
			'subdomain' => $request->subdomain,
		]);
		
		$this->model_user->create([
			'tenant_id'     => $tenant->id,
			'username'      => $request->username,
			'password'      => bcrypt($request->password),
			'people'        => $request->people,
			'name'          => mb_strtoupper($request->name, 'UTF-8'),
			'surname'       => mb_strtoupper($request->surname, 'UTF-8'),
			'corporate_name' => mb_strtoupper($request->corporate_name, 'UTF-8'),
			'email'         => $request->email,
			'phone'         => $request->phone,
			'whatsapp'      => $request->whatsapp,
			'subdomain'     => $request->subdomain,
			'category'      => 'CL',
			'link_confirm'  => 0,
			'is_admin'      => 0,
			'situation'     => 0,
		]);
		
		$obj_data               = new stdClass();
		$obj_data->subdomain    = $request->subdomain;
		$obj_data->name_surname = $request->people == 'F' ? mb_convert_case($request->name.' '.$request->surname, MB_CASE_TITLE) : mb_convert_case($request->corporate_name, MB_CASE_TITLE);
		$obj_data->phone        = Helpers::formata_telefone($request->phone);
		$obj_data->whatsapp     = Helpers::formata_telefone($request->whatsapp);
		$obj_data->email        = $request->email;
		$obj_data->username     = $request->username;
		$obj_data->subdomain    = $request->subdomain;
		$obj_data->to           = $request->email;
		$obj_data->token        = $tenant->uuid;
		$obj_data->url_button_confirm = Helpers::getUrlMainFrontEnd($request->subdomain).'/register/confirm/'.$obj_data->token;
		RegisterClientJob::dispatch($obj_data);
		
		return response()->json(['status' => 1, 'message' => 'Cadastro efetuado com Sucesso.Um e-mail acaba de ser enviado para confirmação do cadastro. Verifique sua caixa de spam.']);
	}
	
	public function confirmedRegister(Request $request)
	{
		if(!isset($request->token) || empty($request->token))
		{
			return response()->json(['status'  => 0, 'message' => 'Token Inexistente!'], 404);
		}
		
		$tenant = $this->model_tenant->where('uuid', $request->token)->first();
		
		if(!$tenant)
		{
			return response()->json(['status'  => 0, 'message' => 'Cadastro Inexistente!'], 404);
		}
		
		$mods = (object) json_decode($tenant->json_tmp, true);
		
		$user = $this->model_user->where('tenant_id', $tenant->id)
															->where('category', 'CL')
															->first();
		
		if($user->link_confirm == 1)
		{
			return response()->json(['status'  => 0, 'message' => 'Link de Confirmação Expirado!'], 400);
		}
		
		$access = $this->model_access->where('tenant_id', $tenant->id)->first();
		
		if(!$access)
		{
			$dataAccess = [
				'tenant_id'      => $tenant->id,
					 'period'      => 1,
						 'type'      => 'T',
				'situation'      => 'A',
			 'date_start'      => Carbon::now()->format('Y-m-d'),
				 'date_end'      => Carbon::parse(Carbon::now())->addDays(3)
			];
			
			$this->model_access->create($dataAccess);
		}
		
		$this->model_user->where('id', $user->id)
					->update([
						'situation'    => 1,
						'link_confirm' => 1
					]);
		
		$obj_data                    = new stdClass();
		$obj_data->url_button_access = Helpers::getUrlMainFrontEnd($tenant->subdomain).'/login';
		$obj_data->to                = $user->email;
		ConfirmedRegisterClientJob::dispatch($obj_data);
		
		return response()->json(['status'  => 1, 'message' => 'Ativação efeutado com Sucesso!']);
	}
}
