<?php

namespace App\Events;


use Illuminate\Broadcasting\InteractsWithSockets;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MarathonRegisterEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $marathonRegister;

    public function __construct($marathonRegister)
    {
     

        $this->marathonRegister = $marathonRegister;
    }
}
