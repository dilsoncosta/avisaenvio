<?php

namespace App\Jobs;

use App\Models\Access;
use App\Models\Charge;
use App\Models\Signature;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ChargeAsaasJob implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	
	public $tries = 3;
	
	public $data;

	public function __construct($data)
	{
		$this->data = $data;
	}
	
	public function handle()
	{
		switch ($this->data->payment['status'])
		{
			case 'CONFIRMED':
				$statusPayment = 1;
				break;
			default:
				$statusPayment = 0;
				break;
		}
		
		$model_signature = new Signature();
		$signature = $model_signature->where('asaas_id', $this->data->payment['subscription'])->first();
		
		if(!$signature)
		{
			return;
		}
		
		$model_charge = new Charge();
		$charge = $model_charge->where('asaas_charge_id', $this->data->payment['id'])
													->where('tenant_id', $signature->tenant_id)->first();
		
		if($charge)
		{
			if($charge->situation == 1)
			{
				return;
			}
		}
		
		if(!$charge)
		{
			$model_charge->create([
				'tenant_id'                     => $signature->tenant_id,
				'type'                          => 2,
				'description'                   => $this->data->payment['description'],
				'venc'                          => $this->data->payment['originalDueDate'],
				'situation'                     => $statusPayment,
				'total'                         => $this->data->payment['value'],
				'ind_mod_order_tracking'        => $signature->ind_mod_order_tracking,
				'ind_mod_hotel'                 => $signature->ind_mod_hotel,
				'asaas_charge_id'               => $this->data->payment['id'],
				'asaas_invoice_number'          => $this->data->payment['invoiceNumber'],
				'asaas_transition_receipt_url'  => $this->data->payment['transactionReceiptUrl'],
				'asaas_client_payment_date'     => $this->data->payment['clientPaymentDate'],
				'asaas_situation'               => $this->data->payment['status'],
			]);
			
			$ind_mod_order_tracking = $signature->ind_mod_order_tracking;
			$ind_mod_hotel          = $signature->ind_mod_hotel;
		}
		else
		{
			$ind_mod_order_tracking = $charge->ind_mod_order_tracking;
			$ind_mod_hotel          = $charge->ind_mod_hotel;
			
			$model_charge->where('id', $charge->id)->update([
				'tenant_id'                     => $signature->tenant_id,
				'type'                          => 2,
				'description'                   => $this->data->payment['description'],
				'venc'                          => $this->data->payment['originalDueDate'],
				'situation'                     => $statusPayment,
				'total'                         => $this->data->payment['value'],
				'asaas_charge_id'               => $this->data->payment['id'],
				'asaas_invoice_number'          => $this->data->payment['invoiceNumber'],
				'asaas_transition_receipt_url'  => $this->data->payment['transactionReceiptUrl'],
				'asaas_client_payment_date'     => $this->data->payment['clientPaymentDate'],
				'asaas_situation'               => $this->data->payment['status'],
			]);
		}
		
		if($statusPayment == 1)
		{
			$model_access = new Access();
			$model_access->where('tenant_id', $signature->tenant_id)->update([
				'ind_mod_order_tracking' => $ind_mod_order_tracking,
				'ind_mod_hotel'          => $ind_mod_hotel,
				'date_end'               => $this->addThirtyDays(),
				'situation'              => 'A'
			]);
		}
	}
	
	private function addThirtyDays()
	{
		$currentDate = Carbon::now();
		$newDate = $currentDate->addDays(30);
		$formattedDate = $newDate->format('Y-m-d');
		
		return $formattedDate;
	}
}
