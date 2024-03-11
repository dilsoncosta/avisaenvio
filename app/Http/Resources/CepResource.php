<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CepResource extends JsonResource
{
	public function toArray($request)
	{
		return [
			'cep'          => $this->cep,
			'address'      => $this->logradouro,
			'complement'   => $this->complemento,
			'neighborhood' => $this->bairro,
			'locality'     => $this->localidade,
			'uf'           => $this->uf,
			'ibge'         => $this->ibge,
		];
	}
}