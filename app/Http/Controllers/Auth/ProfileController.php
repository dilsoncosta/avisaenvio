<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Models\{
	User
};

class ProfileController extends Controller
{
	private $model_user;
	
	public function __construct(User $user)
	{
		$this->model_user = $user;
	}
	
	public function update(ProfileRequest $request)
	{
		$user = $this->model_user->where('username', $request->username)
								->first();
		
		if(!$user)
		{
			return response()->json(['status' => 0, 'message' => 'Username não encontrado!'], 404);
		}
		
		$this->model_user->where('username', $request->username)
				->update([
					'people'        => $request->people,
					'name'          => mb_strtoupper($request->name, 'UTF-8'),
					'surname'       => mb_strtoupper($request->surname, 'UTF-8'),
					'corporate_name' => mb_strtoupper($request->corporate_name, 'UTF-8'),
					'email'         => $request->email,
					'phone'         => $request->phone,
					'whatsapp'      => $request->whatsapp
				]);
		
		return response()->json(['status' => 1, 'message' => 'Registro atualizado com sucesso!']);
	}
}