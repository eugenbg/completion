<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $data;

    /**
     * Create a new message instance.
     *
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = 'noreply@justsayit.works';
        $name = 'Justsayit.works';

        return $this->view('emails/welcome-email')
            ->from($address, $name)
            ->subject('Welcome to justsayit.works')
            ->with([ 'name' => $this->data['name'] ]);
    }
}
