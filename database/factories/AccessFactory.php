<?php

namespace Database\Factories;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Access>
 */
class AccessFactory extends Factory
{
	public function definition()
	{
		$tenant = Tenant::first();
		return [
   'tenant_id' => $tenant->id,
      'period' => 1,
        'type' => 'T',
   'situation' => 'I',
  'date_start' => Carbon::now()->format('Y-m-d'),
    'date_end' => Carbon::parse(Carbon::now())->addDays(3)->format('Y-m-d')
		];
	}
}
