<?php

namespace App\Traits;

use App\Events\NewMessageDispatched;
use App\Models\Message\Message as MessageMessage;
use App\Models\Message\Participant as MessageParticipant;
use App\Models\Message\Thread as MessageThread;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

trait HasMessagesTrait{
    protected $subject, $message;
    protected $recipients = [];

    public function messages(){
        return $this->hasMany(MessageMessage::class);
    }

    public function participants(){
        return $this->hasMany(MessageParticipant::class);
    }

    public function threads(){
        return $this->belongsToMany(MessageThread::class,'participants','user_id','thread_id');
    }

    public function newThreadsCount(){
        return $this->threadsWithNewMessages()->count();
    }

    public function unreadMessages()
    {
        return MessageMessage::unreadForUser($this->getKey())->get();
    }

    public function unreadMessagesCount()
    {
        return count($this->unreadMessages());
    }


    public function threadsWithNewMessages()
    {
        return $this->threads()
            ->where(function (Builder $q) {
                $q->whereIn('threads' . '.id', $this->unreadMessages()->pluck('thread_id'));
            })
            ->get();
    }


    public function starred()
    {
        return $this->hasManyThrough('threads','participants','thread_id','user_id','id','id');
    }

    public function favourites()
    {
        return $this->starred();
    }

    public function getNameAttribute()
    {
        if($this->attributes['name'])
            return $this->attributes['name'];
        
        if($this->name)
            return $this->name;
        
        if($this->first_name)
            return $this->first_name;
        if($this->last_name)
            return $this->last_name;

        // if none is found, just return the email
        return $this->email;
    }


    public function reply($thread){
        if ( ! is_object($thread)) {
           
            $thread = MessageThread::whereId($thread)->firstOrFail();
        }

        $thread->activateAllParticipants();

        $message = $thread->messages()->create([
            'user_id' => $this->id,
            'body' => $this->message
        ]);

        // Add replier as a participant
        $participant = MessageParticipant::firstOrCreate([
            'thread_id' => $thread->id,
            'user_id' => $this->id
        ]);

        $participant->seen_at = Carbon::now();
        $participant->save();

        $thread->updated_at = Carbon::now();
        $thread->save();

        event(new NewMessageDispatched($thread, $message));

        return $message;
    }


}