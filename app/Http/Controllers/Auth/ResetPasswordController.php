<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPassworddRequest;
use App\Models\{
	User,
	PasswordReset
};
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
	private $model_user;
	private $model_password_reset;
	
	public function __construct(User $user, PasswordReset $password_reset)
	{
		$this->model_user           = $user;
		$this->model_password_reset = $password_reset;
	}
	
	public function resetPassword(ResetPassworddRequest $request)
	{
		$updatePassword = $this->model_password_reset->where(['token' => $request->token])
                           ->first();
		
		if(!$updatePassword)
		{
			return response()->json(['status' => 0, 'message' => 'Token Inválido!'], 404);
		}
		
		$this->model_user->where('username', $updatePassword->username)
                    ->update(['password' => Hash::make($request->password)]);
		
		$this->model_password_reset ->where(['token' => $request->token])
         ->delete();
		
		return response()->json(['status' => 1, 'message' => 'Sua senha foi atualizada com sucesso!']);
	}
}