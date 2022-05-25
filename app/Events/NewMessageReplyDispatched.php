<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMessageReplyDispatched
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $thread, $message;

    /**
     * Create a new event instance.
     *
     * @param $thread
     * @param $message
     */
    public function __construct($thread, $message)
    {
        $this->thread = $thread;
        $this->message = $message;
    }
}
