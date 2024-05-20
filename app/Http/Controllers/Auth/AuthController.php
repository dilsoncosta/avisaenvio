<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\{
	User,
	Access,
};
use App\Helpers\Helpers;
use App\Http\Resources\{
	UserPermissionResource,
	UserResource
};
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
	private $model_user;
	private $model_access;
	
	public function __construct(User $user, Access $access)
	{
		$this->model_user                          = $user;
		$this->model_access                        = $access;
	}
	
	public function auth(AuthRequest $request)
	{
		$user = $this->model_user
								->with('tenant')
								->where('username', $request->username)->first();
		
		if (! $user || ! Hash::check($request->password, $user->password)) {
				return response()->json([
					'status'  => 0,
					'message' => 'As credenciais fornecidas estão incorretas.'
				],400);
		}
		
		$subdomain_user = $this->model_user->where('id', $user->id)
													->where('subdomain', $request->subdomain)
													->first();
		
		if(!$subdomain_user)
		{
			return response()->json(['status'  => 0, 'message' => 'O Usuário não pertence a essa empresa. Favor contactar o suporte!'], 400);
		}
		
		if($user->link_confirm == 0)
		{
			return response()->json(['status'  => 0, 'message' => 'Conta Inativa. Confirme o cadastro da conta no e-mail '.$user->email.' para prosseguir o acesso ao sistema!'], 400);
		}
		
		if($user->situation == 0)
		{
			return response()->json(['status'  => 0, 'message' => 'Seu acesso está inativo. Favor contactar o administrador da conta!'], 400);
		}
		
		$access = $this->model_access->where('tenant_id', $user->tenant_id)->first();
		
		if(!$access)
		{
			$dataAccess = [
				'tenant_id'      => $user->tenant_id,
					 'period'      => 1,
						 'type'      => 'T',
				'situation'      => 'A',
			 'date_start'      => Carbon::now()->format('Y-m-d'),
				 'date_end'      => Carbon::parse(Carbon::now())->addDays(7)
			];
			
			$this->model_access->create($dataAccess);
		}
		
		Helpers::loggerUsers('Login no Sistema', 1, $user->username);
		
		// Deleta Todos os Tokens
		$user->tokens()->delete();
		
		$token = $user->createToken($request->device_name)->plainTextToken;
		
		$access = Helpers::getInfoAccess($user->tenant_id);
		
		return response()->json([
			'token'  => $token,
			'user'   => array(
				'id'                       => $user->id,
				'username'                 => $user->username,
				'name'                     => ucfirst(strtolower($user->name)),
				'surname'                  => ucfirst(strtolower($user->surname)),
				'corporate_name'           => ucfirst(strtolower($user->corporate_name)),
				'people'                   => $user->people,
				'email'                    => $user->email,
				'whatsapp'                 => $user->whatsapp,
				'phone'                    => $user->phone,
				'category'                 => $user->category,
				'subdomain'                => $user->subdomain,
				'access'                   => $access->situation,
				'date_end'                 => $access->date_end,
				'ind_mod_order_tracking'   => $access->ind_mod_order_tracking,
				'ind_mod_hotel'            => $access->ind_mod_hotel,
				'permissions'              => isset($user->collaborator->permissions) && count($user->collaborator->permissions) > 0 ? UserPermissionResource::collection($user->collaborator->permissions) : [],
				'situation'                => $user->situation,
				'is_admin'                 => $user->is_admin,
				'avatar'                   => $user->avatar,
			)
		]);
	}
	
	public function me()
	{
		$user   = auth()->user();
		
		$access = Helpers::getInfoAccess($user->tenant_id);
		
		$me = (object) array(
			'uuid'                   => $user->uuid,
			'id'                       => $user->id,
			'username'                 => $user->username,
			'name'                     => ucfirst(strtolower($user->name)),
			'surname'                  => ucfirst(strtolower($user->surname)),
			'corporate_name'           => ucfirst(strtolower($user->corporate_name)),
			'people'                   => $user->people,
			'email'                    => $user->email,
			'whatsapp'                 => $user->whatsapp,
			'avatar'                   => $user->avatar,
			'phone'                    => $user->phone,
			'subdomain'                => $user->subdomain,
			'access'                   => $access->situation,
			'date_end'                 => $access->date_end,
			'ind_mod_order_tracking'   => $access->ind_mod_order_tracking,
			'ind_mod_hotel'            => $access->ind_mod_hotel,
			'permissions'              => isset($user->collaborator->permissions) && count($user->collaborator->permissions) > 0 ? $user->collaborator->permissions : [],
			'category'                 => $user->category,
			'situation'                => $user->situation,
			'is_admin'                 => $user->is_admin,
			'created_at'               => $user->created_at,
			'updated_at'               => $user->updated_at,
		);
		return new UserResource($me);
	}
	
	public function logout()
	{
		if(auth()->user()->category == 'FR' || auth()->user()->category == 'FRCLB')
		{
			Helpers::loggerUsers('Deslogou do Sistema', 2, auth()->user()->username);
		}
		
		auth()->user()->tokens()->delete();
		
		return response()->json([
			"status"  => 0,
			'message' => 'Deslogado com sucesso!'
		]);
	}
}
