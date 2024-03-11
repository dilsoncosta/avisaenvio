<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Tests\Feature\UtilsTrait;

class AuthTest extends TestCase
{
	use UtilsTrait;
	
	public function test_fail_login()
	{
		$user = $this->createUserClient();
		
		$response = $this->postJson('/api/auth', [
			'username'    => $user->username,
			'password'    => "1234563xxx",
			'device_name' => "celular",
			'subdomain'   => $user->subdomain
		]);
		
		$responseData = (object) $response->json();
		
		$response->assertStatus(400)
							->assertJson([
								'status'  => 0,
								'message' => 'As credenciais fornecidas estão incorretas.',
							]);
	}
	
	public function test_user_not_belongs_company()
	{
		$user = $this->createUserClient();
		
		$response = $this->postJson('/api/auth', [
			'username'    => $user->username,
			'password'    => "123456",
			'device_name' => "celular",
			'subdomain'   => 'master_old'
		]);
		
		$responseData = (object) $response->json();
		
		$response->assertStatus(400)
							->assertJson([
								'status'  => 0,
								'message' => "O Usuário não pertence a essa empresa. Favor contactar o suporte!",
							]);
	}
	
	public function test_user_login()
	{
		$user = $this->createUserClient();
		
		$response = $this->postJson('/api/auth', [
			'username'    => $user->username,
			'password'    => "123456",
			'device_name' => "celular",
			'subdomain'   => $user->subdomain
		]);
		
		$responseData = (object) $response->json();
		
		$response->assertStatus(200)
							->assertJson([
								'token' => $responseData->token,
							]);
	}
}
