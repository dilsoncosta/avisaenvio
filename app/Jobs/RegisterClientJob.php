<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class RegisterClientJob implements ShouldQueue
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
		Mail::to($this->data->email)->send(new \App\Mail\RegisterClientMail($this->data));
	}
}
