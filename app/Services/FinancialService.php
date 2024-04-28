<?php
namespace App\Services;

use App\Models\{
	Signature,
	Charge,
	Access
};
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class FinancialService
{
	private $signature;
	private $charge;
	private $access;
	
	public function __construct(Signature $signature, Charge $charge, Access $access)
	{
		$this->signature = $signature;
		$this->charge    = $charge;
		$this->access    = $access;
	}
	
	public function getSignature()
	{
		return $this->signature
								->with(['access'])
								->first();
	}

	public function getCharge()
	{
		return $this->charge->orderBy('id', 'DESC')->get();
	}
	
	public function storeSignature($request)
	{
		if(isset($request->cpf) && strlen($request->cpf) < 12)
		{
			$nameClient = $request->name.' '.$request->surname;
			$document = $request->cpf;
		}
		else
		{
			$nameClient = $request->razap_social;
			$document = $request->cnpj;
		}
		
		if($request->ind_mod == "0"){ $description = "Hotelaria"; } else { $description = "Rastreio de Encomenda"; }
		
		$response = Http::withHeaders([
			'access_token' => config('app.api_asaas_token'),
		])->post(config('app.api_asaas_url').'/customers', [
				"name"                 => $nameClient,
				"email"                => $request->email,
				"phone"                => substr($request->whatsapp, 2),
				"mobilePhone"          => "",
				"cpfCnpj"              => $document,
				"postalCode"           => $request->cep,
				"address"              => $request->address,
				"addressNumber"        => $request->number,
				"complement"           => $request->complement,
				"province"             => $request->neighborhood,
				"externalReference"    => "",
				"notificationDisabled" => false,
				"additionalEmails"     => "",
				"municipalInscription" => "",
				"stateInscription"     => "",
				"observations"         => ""
		]);
		
		$client = $response->object();
		
		if($response->status() != 200)
		{
			return (object) array('status' => 0, 'message' => 'Incapaz de processar o cadastro do cliente!');
		}
		
		$response = Http::withHeaders([
			'access_token' => config('app.api_asaas_token'),
		])->post(config('app.api_asaas_url').'/subscriptions', [
				"billingType"   => "CREDIT_CARD",
				"cycle"         => "MONTHLY",
				"creditCard" => [
					"holderName"  => $request->card_name,
					"number"      => $request->card_number,
					"expiryMonth" => $request->card_month_exp,
					"expiryYear"  => $request->card_year_exp,
					"ccv"         => $request->card_cvv,
				],
				"creditCardHolderInfo" => [
					"name"              => $nameClient,
					"email"             => $request->email,
					"cpfCnpj"           => $document,
					"postalCode"        => $request->cep,
					"addressNumber"     => $request->number,
					"addressComplement" => $request->complement,
					"phone"             => $request->whatsapp,
					"mobilePhone"       => ""
				],
				"customer"        => $client->id,
				"nextDueDate"     => Carbon::now()->format('Y-m-d'),
				"value"           => $request->total,
				"description"     => "Módulo: ".$description,
				"creditCardToken" => str::uuid()
		]);
		$signature = $response->object();

		
		if($response->status() != 200)
		{
			return (object) array('status' => 0, 'message' => $signature->errors[0]->description);
		}
		
		$this->signature->where('tenant_id', auth()->user()->tenant_id)->delete();

		$dataSignature = [
			'frequency'                  => 1,
			'next_due_date'              => Carbon::now()->format('Y-m-d'),
			'automatic_renovation'       => 1,
			'situation'                  => 1,
			'payment'                    => 2,
			'total'                      => $request->total,
			'ind_mod_order_tracking'     => $request->ind_mod == 0 ? 1 : 0,
			'ind_mod_hotel'              => $request->ind_mod == 1 ? 1 : 0,
			'address_type'               => $request->type,
			'address_corporate_reason'   => $request->razap_social,
			'address_cnpj'               => $request->cnpj,
			'address_cpf'                => $request->cpf,
			'address_name'               => $request->name,
			'address_surname'            => $request->surname,
			'address_email'              => $request->email,
			'address_whatsapp'           => $request->whatsapp,
			'address_phone'              => $request->phone,
			'address_cep'                => $request->cep,
			'address_state'              => $request->state,
			'address_city'               => $request->city,
			'address_neighborhood'       => $request->neighborhood,
			'address_street'             => $request->address,
			'address_number'             => $request->number,
			'address_complement'         => $request->complement,
			'asaas_credit_card_number'   => $signature->creditCard->creditCardNumber,
			'asaas_credit_card_brand'    => $signature->creditCard->creditCardBrand,
			'asaas_credit_card_token'    => $signature->creditCard->creditCardToken,
			'asaas_object'               => $signature->object,
			'asaas_id'                   => $signature->id,
			'asaas_date_created'         => Carbon::now()->format('Y-m-d'),
			'asaas_customer_id'          => $client->id,
			'asaas_status'               => $signature->status,
			'asaas_description'          => $signature->description,
		];
		
		$dataSignature = $this->signature->create($dataSignature);
		
		$response = Http::withHeaders([
			'access_token' => config('app.api_asaas_token'),
		])->get(config('app.api_asaas_url').'/subscriptions/'.$signature->id.'/payments', []);
		
		$charge = $response->object();
		
		if($response->status() != 200)
		{
			return (object) array('status' => 0, 'message' => $charge->errors[0]->description);
		}
		
		switch ($charge->data[0]->status)
		{
			case 'CONFIRMED':
				$statusPayment = 1;
				break;
			default:
				$statusPayment = 0;
				break;
		}
		
		$dataCharge = [
			'type'                          => 2,
			'description'                   => $charge->data[0]->description,
			'venc'                          => $charge->data[0]->originalDueDate,
			'situation'                     => $statusPayment,
			'total'                         => $charge->data[0]->value,
			'ind_mod_order_tracking'        => $request->ind_mod == 0 ? 1 : 0,
			'ind_mod_hotel'                 => $request->ind_mod == 1 ? 1 : 0,
			'asaas_charge_id'               => $charge->data[0]->id,
			'asaas_invoice_number'          => $charge->data[0]->invoiceNumber,
			'asaas_transition_receipt_url'  => $charge->data[0]->transactionReceiptUrl,
			'asaas_client_payment_date'     => $charge->data[0]->clientPaymentDate,
			'asaas_situation'               => $charge->data[0]->status,
		];
		
		$this->charge->create($dataCharge);
		
		if($statusPayment == 1)
		{
			$this->access->where('tenant_id', auth()->user()->tenant_id)->update([
				'date_start' => Carbon::now()->format('Y-m-d'),
				'date_end'   => $this->addThirtyDays(),
				'ind_mod_order_tracking'     => $request->ind_mod == 0 ? 1 : 0,
				'ind_mod_hotel'              => $request->ind_mod == 1 ? 1 : 0,
			]);
		}
		
		return (object) array('status' => 1, 'message' => "");
	}
	
	private function addThirtyDays()
	{
		$currentDate = Carbon::now();
		$newDate = $currentDate->addDays(30);
		$formattedDate = $newDate->format('Y-m-d');

		return $formattedDate;
	}

	public function canceledSignature()
	{
		$response = Http::withHeaders([
			'access_token' => config('app.api_asaas_token'),
		])->put(config('app.api_asaas_url').'/subscriptions/'.$this->getSignature()->asaas_id, [
				"status" => 'INACTIVE'
		]);
		
		$signature = $response->object();
		
		if($response->status() != 200)
		{
			return (object) array('status' => 0, 'message' => $signature->errors[0]->description);
		}
		
		$this->signature->where('tenant_id', auth()->user()->tenant_id)->update([
			'date_canceled'        => Carbon::now()->format('Y-m-d'),
			'situation'            => 2,
			'automatic_renovation' => 0
		]);

		return (object) array('status' => 1, 'message' => "");
	}
}
