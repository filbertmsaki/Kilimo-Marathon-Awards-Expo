<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MessageDispatched extends Notification
{
    use Queueable;

    public $thread, $message, $participant;

    /**
     * Create a new notification instance.
     *
     * @param Thread  $thread
     * @param Message $message
     * @param         $participant
     */
    public function __construct($thread, $message, $participant)
    {
        $this->thread = $thread;
        $this->message = $message;
        $this->participant = $participant;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $buttonUrl = route('admin.messages.show', $this->thread);
        $isReply = $this->thread->messages()->count() >= 2;
        $greeting = $isReply ? 'Re: ' . $this->thread->subject : $this->thread->subject;

        return (new MailMessage)
            ->success()
            ->subject($this->message->user->name . ' ' . trans('messages.notification.subject') . ' - ' . config('app.name'))
            ->greeting($greeting)
            ->line($this->message->body)
            ->action(trans('messages.notification.button'), $buttonUrl);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'thread_id' => $this->thread->id,
            'message_id' => $this->message->id,
            'isReply' => $this->thread->messages()->count() >= 2,
        ];
    }

    /**
     * Get the database representation of the notification.
     *
     * @param  mixed $notifiable
     *
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'thread_id' => $this->thread->id,
            'message_id' => $this->message->id,
            'isReply' => $this->thread->messages()->count() >= 2,
        ];
    }
}
