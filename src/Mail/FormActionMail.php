<?php

namespace Chuckbe\Chuckcms\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FormActionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->mailData['from'], $this->mailData['from_name'])
                    ->to($this->mailData['to'], $this->mailData['to_name'])
                    ->subject($this->mailData['subject'])
                    ->view('chuckcms::templates.chuckv1.mails.form');
    }
}