<?php

namespace App\Models\Message;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory,SoftDeletes;

     
    protected $table = 'messages';

    protected $touches = ['thread'];

    protected $fillable = ['thread_id', 'user_id', 'body'];

    protected $dates = ['deleted_at'];

    public function thread(){
        return $this->belongsTo(Thread::class, 'thread_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function participants(){
        return $this->hasMany(Participant::class, 'thread_id', 'thread_id');
    }

    public function recipients(){
        return $this->participants()->where('user_id', '!=', $this->user_id);
    }

    public function scopeUnreadForUser(Builder $query, int $userId): Builder
    {
        return $query->has('thread')
            ->where('user_id', '!=', $userId)
            ->whereHas('participants', function (Builder $query) use ($userId) {
                $query->where('user_id', $userId)
                    ->where(function (Builder $q) {
                        $q->where('seen_at', '<', $this->getConnection()->raw($this->getConnection()->getTablePrefix() . $this->getTable() . '.created_at'))
                            ->orWhereNull('seen_at');
                    });
            });
    }

}
