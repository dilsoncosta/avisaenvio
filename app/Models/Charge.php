<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\TenantTrait;

class Charge extends Authenticatable
{
	use HasApiTokens, HasFactory, Notifiable, TenantTrait;
	
	protected $table = 'charges';
	
	protected $fillable = [
		'tenant_id',
		'uuid',
		'type',
		'description',
		'venc',
		'situation',
		'total',
		'ind_mod_order_tracking',
		'ind_mod_hotel',
		'asaas_charge_id',
		'asaas_invoice_number',
		'asaas_transition_receipt_url',
		'asaas_client_payment_date',
		'asaas_situation'
	];
}
