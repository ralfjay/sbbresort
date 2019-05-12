<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Session;

class SendEmailConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $emailconfirmationdata;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($emailconfirmationdata)
    {
        //
        $this->emailconfirmationdata = $emailconfirmationdata;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       return $this->from(Session::get('resort_email')[0]['email'])->subject('Booking Confirmation')->view('emailconfirmation')->with('emailconfirmationdata',$this->emailconfirmationdata);
    }
}
