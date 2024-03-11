<?php

namespace App\Mail;

use Illuminate\Mail\Mailables\Address;
use Illuminate\Bus\Queueable; 
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Support\Facades\Storage;

class CrmSendEmailMail extends Mailable
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
			subject: $this->data->email_subject,
			from: new Address($this->data->email_email_sender, $this->data->email_name_sender),
		);
	}
	
	public function content()
	{
		return new Content(
			view: 'emails.crmSendEmailMail',
			with: [
				'data' => $this->data,
			],
		);
	}
	
	public function attachments()
	{
		$attachments = [];
		
		if ($this->data->file_1 && Storage::exists($this->data->file_1)) {
			$attachments[] = Attachment::fromStorage($this->data->file_1)->as($this->data->filename_1);
		}
		if ($this->data->file_2 && Storage::exists($this->data->file_2)) {
			$attachments[] = Attachment::fromStorage($this->data->file_2)->as($this->data->filename_2);
		}
		if ($this->data->file_3 && Storage::exists($this->data->file_3)) {
			$attachments[] = Attachment::fromStorage($this->data->file_3)->as($this->data->filename_3);
		}
		return $attachments;
	}
}
