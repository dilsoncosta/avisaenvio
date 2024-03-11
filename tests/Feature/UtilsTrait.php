<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Tenant;
use App\Models\Access;

trait UtilsTrait
{
	public function createUserClient()
	{
		$tenant = Tenant::factory()->create();
		$user = User::factory()->create();
		$access = Access::factory()->create();
		
		return $user;
	}
	
	public function createTokenUser()
	{
		$user = $this->createUser();
		$token = $user->createToken('teste')->plainTextToken;
		return $token;
	}
	
	public function defaultHeaders()
	{
		$token = $this->createTokenUser();
		
		return [
			'Authorization' => "Bearer {$token}",
		];
	}
}