<?php

namespace App\Listeners;

use App\Notifications\MessageDispatched;

class SendMessageNotification
{
    public function handle($event)
    {
        $thread = $event->thread;
        $message = $event->message;

        $participants = $thread->participants()
                               ->where('user_id', '!=', $message->user_id)
                               ->get();

        if ($participants->count()) {
            foreach ($participants as $participant) {
                $participant->notify(new MessageDispatched($thread, $message, $participant));
            }
        }
    }
}
