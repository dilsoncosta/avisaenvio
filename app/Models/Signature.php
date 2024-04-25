<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\TenantTrait;

class Signature extends Authenticatable
{
	use HasApiTokens, HasFactory, Notifiable, TenantTrait;
	
	protected $table = 'signatures';
	
	protected $fillable = [
		'tenant_id',
		'uuid',
		'frequency',
		'next_due_date',
		'automatic_renovation',
		'situation',
		'payment',
		'total',
		'ind_mod_order_tracking',
		'ind_mod_hotel',
		'address_type',
		'address_corporate_reason',
		'address_cnpj',
		'address_cpf',
		'address_name',
		'address_surname',
		'address_email',
		'address_whatsapp',
		'address_phone',
		'address_cep',
		'address_state',
		'address_city',
		'address_neighborhood',
		'address_street',
		'address_number',
		'address_complement',
		'asaas_credit_card_number',
		'asaas_credit_card_brand',
		'asaas_credit_card_token',
		'asaas_object',
		'asaas_id',
		'asaas_date_created',
		'asaas_customer_id',
		'asaas_status',
		'asaas_description',
	];

	public function access()
	{
		return $this->hasOne(Access::class, 'tenant_id', 'tenant_id');
	}
}
