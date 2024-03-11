<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPassowrdRequest;
use App\Jobs\RecoveryPasswordJob;
use App\Models\{
	User,
	PasswordReset
};
use Illuminate\Support\Str;
use Carbon\Carbon;
use stdClass;
use App\Helpers\Helpers;

class ForgotPasswordController extends Controller
{
	private $model_user;
	private $model_password_reset;
	
	public function __construct(User $user, PasswordReset $password_reset)
	{
		$this->model_user           = $user;
		$this->model_password_reset = $password_reset;
	}

	public function sendResetLink(ForgotPassowrdRequest $request)
	{
		$user = $this->model_user->where('username', '=', $request->input('username'))
														->where('email', '=', $request->input('email'))
														->where('situation', '=', 1)->first();
		
		if(!$user){
			return response()->json(['message' => 'Usuário/E-mail não encontrado ou inativo!'],400);
		}
		
		$token = Str::random(60);
		
		$this->model_password_reset->create([
      'username'   => $request->username, 
      'token'      => $token, 
      'created_at' => Carbon::now()
		]);
		
		$obj_data                      = new stdClass();
		$obj_data->url_button_recovery = Helpers::getUrlMainFrontEnd($user->subdomain).'/reset-password/'.$token;
		$obj_data->name                = mb_convert_case($user->name, MB_CASE_TITLE);
		$obj_data->surname             = mb_convert_case($user->surname, MB_CASE_TITLE);
		$obj_data->to                  = $request->email;
		RecoveryPasswordJob::dispatch($obj_data);
		
		return response()->json(['status' => 1, 'message' => 'Uma mensagem acaba de ser enviada para o seu e-mail com as instruções para redefinição de sua senha de acesso. Obs.: Verifique sua caixa de spam!']);
	}
}