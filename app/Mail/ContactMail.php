<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $request;

    /** Create a new message instance. ...
     * @param $request
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /** Build the message. ...*/
    public function build()
    {

        return $this->from($this->request->cc . '@thevinylshop.com', 'The Vinyl Shop - ' . $this->request->cc)
            ->cc($this->request->cc . '@thevinylshop.com', 'The Vinyl Shop - ' . $this->request->cc)
            ->subject('The Vinyl Shop - Contact Form')
            ->markdown('email.contact');
    }
}
