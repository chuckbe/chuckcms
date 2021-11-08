<?php

namespace Chuckbe\Chuckcms\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserActivationMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $mailData;

    public $settings;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailData, $settings)
    {
        $this->mailData = $mailData;
        $this->settings = $settings;
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
                    ->subject('Activeer je account op '.$this->settings['domain'])
                    ->view('chuckcms::backend.mails.userActivationMail');
    }
}
