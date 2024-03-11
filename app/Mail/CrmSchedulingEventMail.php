<?php

namespace App\Mail;

use Illuminate\Mail\Mailables\Address;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CrmSchedulingEventMail extends Mailable
{
	private $data;
	
	use Queueable, SerializesModels;
	
	public function __construct($data)
	{
		$this->data = $data;
	}
	
	public function envelope()
	{
		return new Envelope(
			subject: config('app.mail_from_name').' - Convite! '.$this->data->title,
			from: new Address(config('app.mail_from_address'), config('app.mail_from_name')),
		);
	}
	
	public function content()
	{
		return new Content(
			markdown: 'emails.schedulingEventMail',
			with: [
				'data' => $this->data,
			],
		);
	}
	
	public function attachments()
	{
		return [];
	}
}
