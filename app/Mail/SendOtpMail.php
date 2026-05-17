<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendOtpMail extends Mailable
{
    use Queueable, SerializesModels;
    public $otp,$user;
    

    public function __construct($otp,$user)
    {
        $this->otp = $otp;
        $this->user = $user;
    }
    
    public function build()
    {
        return $this->subject('Email Verification OTP')
            ->view('emails.otp');
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
