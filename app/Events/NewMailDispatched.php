<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMailDispatched
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $thread, $conversation;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($thread, $conversation)
    {
        $this->thread = $thread;
        $this->conversation = $conversation;
    }


}
