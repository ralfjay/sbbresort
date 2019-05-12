<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Session;

class SendEmailModifySuccess extends Mailable
{
    use Queueable, SerializesModels;

    public $emailmodifysuccessdata;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($emailmodifysuccessdata)
    {
        //
        $this->emailmodifysuccessdata = $emailmodifysuccessdata;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(Session::get('resort_email')[0]['email'])->subject('Modify Booking')->view('cx.emailmodifysuccess')->with('emailmodifysuccessdata',$this->emailmodifysuccessdata);
    }
}
