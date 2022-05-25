<?php

namespace App\Models\Message;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;


class Participant extends Model
{
    use HasFactory, SoftDeletes, Notifiable;
    
  
    protected $table = 'participants';

    protected $fillable = ['thread_id', 'user_id', 'seen_at', 'starred'];

    protected $dates = ['deleted_at', 'seen_at','deleted_for_sender','deleted_for_receiver'];

    protected $casts = ['starred' => 'boolean',];

    public function thread(){
        return $this->belongsTo(Thread::class, 'thread_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function threads() {
        return $this->belongsToMany(Thread::class, 'participants', 'thread_id', 'user_id');
    }

    

   
}
