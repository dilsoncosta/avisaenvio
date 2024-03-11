<?php

namespace Database\Factories;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
	public function definition()
	{
		$tenant = Tenant::first();
		return [
			'tenant_id'    => $tenant->id,
			'username'     => 'admin',
			'password'     => bcrypt('123456'),
			'people'       => 'F',
			'name'         => 'DILSON',
			'surname'      => 'LANA',
			'email'        => 'dilsonlana@gmail.com',
			'phone'        => '5531982096315',
			'whatsapp'     => '5531982096315',
			'subdomain'    => 'master',
			'link_confirm' => 1,
			'category'     => 'MT',
			'situation'    => 1
		];
	}
}
