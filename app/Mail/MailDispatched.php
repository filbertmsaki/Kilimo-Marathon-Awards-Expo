<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailDispatched extends Mailable
{
    use Queueable, SerializesModels;
    private $data, $email;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $email)
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
        
        $email = $this->view('emails.welcome',[ 'data' => $this->data])
                ->to($this->email)
                ->from('marketing@kilimomarathon.co.tz', 'Kilimo Marathon, Awards & EXPO')
                ->subject($this->data['subject']);
                //For Cc The Message
                if(!empty($this->data['cc'])){
                    foreach($this->data['cc'] as $id){
                            $email->cc($id);
                    }

                }
                //For Bcc The Message
                if(!empty($this->data['bcc'])){
                    foreach($this->data['bcc'] as $id){
                       
                        $email->bcc($id);
                    }

                }

                //Mail Attachment
                if($this->data['attachments']){
                    foreach($this->data['attachments'] as $file){
                        $email->attach($file->getRealPath(),[
                            'as'=> $file->getClientOriginalName()
                        ]);
                    }

                }

               
    }
}
