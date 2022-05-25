<?php

namespace App\Models\Message;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Thread extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'threads';

    protected $fillable = ['subject','user_id', 'slug', 'max_participants'];

    protected $dates = ['deleted_at'];

    protected $creatorCache = null;
    public function getRouteKeyName(){
    return 'slug';
    }
    
    public function messages(){
        return $this->hasMany(Message::class, 'thread_id', 'id');
    }

    public function getLatestMessageAttribute(){
        return $this->messages()->latest()->first();
    }

    public function participants(){
        return $this->hasMany(Participant::class);
    }

    public function users(){
        return $this->belongsToMany(User::class,'participants', 'thread_id', 'user_id');
    }

    public function creator(){
        if ($this->creatorCache === null) {
            $firstMessage = $this->messages()->withTrashed()->oldest()->first();
            $this->creatorCache = $firstMessage ? $firstMessage->user : User::class;
        }

        return $this->creatorCache;
    }

    public static function getAllLatest(){
        return static::latest('updated_at');
    }

    public static function getBySubject(string $subject){
        return static::where('subject', 'like', $subject)->get();
    }

    public function participantsUserIds($userId = null)
    {
        $users = $this->participants()->select('user_id')->get()->map(function ($participant) {
            return $participant->user_id;
        });

        if ($userId) {
            $users->push($userId);
        }

        return $users->toArray();
    }

    public function participantsUserIdsWithTrashed($userId = null)
    {
        $users = $this->participants()->withTrashed()->select('user_id')->get()->map(function ($participant) {
            return $participant->user_id;
        });

        if ($userId) {
            $users->push($userId);
        }

        return $users->toArray();
    }

    public function scopeForUser(Builder $query, int $userId){

        return $query->join('participants', 'threads.id', '=', 'participants'.'.thread_id')
        ->whereNull('participants'.'.deleted_at')
        ->where('participants.user_id',$userId)
        ->select('threads'.'.*');
    }
    public function scopeSentForUser(Builder $query, int $userId){

        return $query->join('participants', 'threads.id', '=', 'participants'.'.thread_id')
        ->whereNull('participants'.'.deleted_for_sender')
        ->where('threads.user_id',$userId)
        ->groupBy('threads.id','participants.thread_id', 'threads.user_id',
                    'threads.subject','threads.slug',
                    'threads.max_participants','threads.deleted_at',
                    'threads.created_at','threads.updated_at',
                )
        ->select('threads'.'.*');
    }

    public function scopeTrashForUser(Builder $query, int $userId){

        return $query->join('participants', 'threads.id', '=', 'participants'.'.thread_id')
        ->whereNotNull('participants'.'.deleted_at')
        ->whereNull('participants'.'.deleted_for_receiver')
        ->where('participants.user_id',$userId)
        ->select('threads'.'.*');
    }

    public function scopeForUserWithNewMessages(Builder $query, int $userId)
    {
        $participantTable = 'participants';
        $threadsTable = 'threads';

        return $query->join($participantTable, $this->getQualifiedKeyName(), '=', $participantTable . '.thread_id')
            ->where($participantTable . '.user_id', $userId)
            ->whereNull($participantTable . '.deleted_at')
            ->where(function (Builder $query) use ($participantTable, $threadsTable) {
                $query->where($threadsTable . '.updated_at', '>', $this->getConnection()->raw($this->getConnection()->getTablePrefix() . $participantTable . '.seen_at'))
                    ->orWhereNull($participantTable . '.seen_at');
            })
            ->select($threadsTable . '.*');
    }

    public function scopeBetweenOnly(Builder $query, array $participants)
    {
        return $query->whereHas('participants', function (Builder $builder) use ($participants) {
            return $builder->whereIn('user_id', $participants)
                           ->groupBy('participants.thread_id')
                           ->select('participants.thread_id')
                           ->havingRaw('COUNT(participants.thread_id)=?', [count($participants)]);
        });
    }

    public function scopeBetween(Builder $query, array $participants)
    {
        return $query->whereHas('participants', function (Builder $q) use ($participants) {
            $q->whereIn('user_id', $participants)
                ->select($this->getConnection()->raw('DISTINCT(thread_id)'))
                ->groupBy('thread_id')
                ->havingRaw('COUNT(thread_id)=' . count($participants));
        });
    }


  
    public function addParticipant(array $participants)
    {
        if (count($participants)) {
            foreach ($participants as $user_id) {
                $participant = Participant::firstOrCreate([
                    'thread_id' => $this->id,
                    'user_id' => $user_id,
                ]);

                $participant->seen_at = null;
                $participant->save();
            }
        }
    }

    public function removeParticipant($userId)
    {
        $userIds = is_array($userId) ? $userId : (array) func_get_args();

        return Participant::where('thread_id', $this->id)->whereIn('user_id', $userIds)->delete();
    }


    public function isUnread($thread)
    {

        
        $userId =  auth()->id();

        $participant = Participant::where('user_id', $userId)->whereNull('seen_at')->where('thread_id',$thread)
                            ->first();
        if ($participant && $participant->seen_at === null) {
            return true;
        }

        return false;
    }

    
    public function getParticipantFromUser($userId)
    {
        
        return $this->participants()->where('user_id', $userId)->firstOrFail();
    }
    
    public function activateAllParticipants()
    {
        $participants = $this->participants()->onlyTrashed()->get();
        foreach ($participants as $participant) {
            $participant->restore();
        }
    }
    
    public function participantsString($userId = null, $columns = [])
    {

        if(empty($columns))
             $columns = ['name'];

        $selectString = $this->createSelectString($columns);

        $participantNames = $this->getConnection()->table('users')
            ->join('participants', 'users.id', '=', 'participants.user_id')
            ->where('participants.thread_id', $this->id)
            ->select($this->getConnection()->raw($selectString));

        if ($userId !== null) {
            $participantNames->where('users.id', '!=', $userId);
        }

        return $participantNames->implode('name', ', ');
    }

    public function hasParticipant($userId)
    {
        $participants = $this->participants()->where('user_id', '=', $userId);
        if ($participants->count() > 0) {
            return true;
        }

        return false;
    }

    protected function createSelectString(array $columns): string
    {
        $dbDriver = $this->getConnection()->getDriverName();
        $tablePrefix = $this->getConnection()->getTablePrefix();
        $usersTable = 'users';

        switch ($dbDriver) {
        case 'pgsql':
        case 'sqlite':
            $columnString = implode(" || ' ' || " . $tablePrefix . $usersTable . '.', $columns);
            $selectString = '(' . $tablePrefix . $usersTable . '.' . $columnString . ') as name';

            break;
        case 'sqlsrv':
            $columnString = implode(" + ' ' + " . $tablePrefix . $usersTable . '.', $columns);
            $selectString = '(' . $tablePrefix . $usersTable . '.' . $columnString . ') as name';

            break;
        default:
            $columnString = implode(", ' ', " . $tablePrefix . $usersTable . '.', $columns);
            $selectString = 'concat(' . $tablePrefix . $usersTable . '.' . $columnString . ') as name';
        }

        return $selectString;
    }

    public function getMaxParticipants()
    {
        return $this->max_participants;
    }

    public function hasMaxParticipants()
    {
        $participants = $this->participants();
        if ($participants->count() > $this->max_participants) {
            // max number of participants reached
            return true;
        }
        return false;
    }


 
}
