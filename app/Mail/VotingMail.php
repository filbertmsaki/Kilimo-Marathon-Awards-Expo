<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VotingMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $data;
    public $email;

    public function __construct($data,$email)
    {
        $this->data = $data;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->view('admin.mails.mail-shot-compose',[ 'data' => $this->data])
        ->to($this->email)
        ->from('marketing@kilimomarathon.co.tz', 'Kilimo Marathon, Awards & EXPO')
        ->subject($this->data['subject']);
      
       

       
    }
}
