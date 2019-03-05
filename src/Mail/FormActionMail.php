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
        $mail = $this->from($this->mailData['from'], $this->mailData['from_name'])
                    ->to($this->mailData['to'], $this->mailData['to_name'])
                    ->subject($this->mailData['subject'])
                    ->view($this->mailData['template']);
        if (is_array($this->mailData['files'])) {
            foreach ($this->mailData['files'] as $file) {
                if ($file !== null) {
                    $mail->attach(public_path($file));    
                }
            }
        }
        return $mail;
    }
}
