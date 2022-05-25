<?php

namespace App\Http\Controllers\Admin;

use App\Events\NewMessageDispatched;
use App\Http\Controllers\Controller;
use App\Models\Message\Participant as MessageParticipant;
use App\Models\Message\Thread as MessageThread;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }
    public function index(){


        DB::enableQueryLog();
        // dd(DB::getQueryLog());
        $threads = MessageThread::forUser(Auth::id())->latest('updated_at')->paginate(10);
    
      
        $participants = MessageParticipant::where('user_id', auth()->id())->whereNull('deleted_at')->get();
        // All threads that user is participating in, with new messages
        // $threads = MessageThread::forUserWithNewMessages(Auth::id())->latest('updated_at')->paginate(10);
        return view('admin.messages.inbox',compact('threads','participants'));
    }

    public function sent_messages(){        
        $threads = MessageThread::sentForUser(Auth::id())->latest('updated_at')->paginate(10);
        
        return view('admin.messages.sent',compact('threads'));
    }

    public function read_sent_messages($thread){

        try {
            $threads = MessageThread::where('slug',$thread)->first();
           
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('dander','The thread with ID: ' . $thread . ' was not found.');
        }

        // show current user in list if not a current participant
        // $users = User::whereNotIn('id', $thread->participantsUserIds())->get();

        // don't show the current user in list
        $userId = auth()->id();
        $users = User::whereNotIn('id', $threads->participantsUserIds($userId))->get();
        return view('admin.messages.read-sent-message', compact('users', 'threads'));

    }
    public function trash_messages(){
        $threads = MessageThread::TrashForUser(Auth::id())->latest('updated_at')->paginate(10);
        return view('admin.messages.trash',compact('threads'));

    }
    public function read_trash_messages($thread){

        try {
            $threads = MessageThread::where('slug',$thread)->first();
           
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('dander','The thread with ID: ' . $thread . ' was not found.');
        }

        // show current user in list if not a current participant
        // $users = User::whereNotIn('id', $thread->participantsUserIds())->get();

        // don't show the current user in list
        $userId = auth()->id();
        $users = User::whereNotIn('id', $threads->participantsUserIds($userId))->get();
        return view('admin.messages.read-trash-message', compact('users', 'threads'));

    }
    public function create(){
        $users = User::whereNotNull('email_verified_at')->where('id','!=', auth()->id())->get();
        return view('admin.messages.compose',compact('users'));     
    }
    public function store(Request $request){
        $request->validate([
            'subject' => 'required',
            'body' => 'required',
            'recipients' => 'required|array',
        ]);
        $thread_slug = Str::random(40);
        $i = 0;
        while(MessageThread::where('slug',$thread_slug)->exists())
        {
            $i++;
            $thread_slug = Hash::make(Str::random(40).$i);
        }
            
        $thread = MessageThread::create([
            'user_id' =>auth()->id(),
            'slug' =>   $thread_slug,
            'subject' => $request->subject,
        ]);

        // Message
     
        $message = $thread->messages()->create([
            'user_id' => auth()->id(),
            'body' => $request->body
        ]);


        if (count($request->recipients)) {
            $thread->addParticipant($request->recipients);
        }

        if ($thread) {
            event(new NewMessageDispatched($thread, $message));
        }

        return redirect()
            ->route('admin.messages.index')
            ->with('success',  trans('messages.message.sent'));

    }
    public function show($thread){ 

        try {
            $threads = MessageThread::where('slug',$thread)->first();
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('dander','The thread with ID: ' . $thread . ' was not found.');

        }

        // don't show the current user in list
        $userId = Auth::id();
        $users = User::whereNotIn('id', $threads->participantsUserIds($userId))->get();
      
        // Mark  Message as  read

        $participant= MessageParticipant::where('user_id', auth()->id())->where('thread_id', $threads->id)->first();
        $participant =$participant->update(['seen_at' => new Carbon()]);
 

        return view('admin.messages.read-message', compact('users', 'threads'));

       
    }
    public function reply(Request $request, $thread){

    }

    public function destroy($thread){
        $threads = MessageThread::where('slug',$thread)->first();
        $message = MessageParticipant::where('user_id', auth()->id()) ->where('thread_id', $threads->id)->firstOrFail();
        $message->delete();
        return redirect()->route('admin.messages.index') ->with('danger',trans('messages.thread.trash'));
    }

    public function destroy_all(Request $request){
        $request->validate([
            'thread_id' => 'required|array',
        ]);
        foreach ($request->thread_id as $id) {
           $threads = MessageThread::findOrFail($id);
           $message = MessageParticipant::where('user_id', auth()->id()) ->where('thread_id', $threads->id)->firstOrFail();
           $message->delete();
       }
       return redirect()->route('admin.messages.index') ->with('danger',trans('messages.thread.trash'));
    }
    public function restore_destroyed_message($thread) 
    {
        $threads = MessageThread::where('slug',$thread)->first();
        $message = MessageParticipant::where('user_id', auth()->id())->where('thread_id', $threads->id)->withTrashed()->firstOrFail();
        $message->restore();
        return redirect()->back()->with('warning', trans('messages.thread.restore'));
    }

    public function restore_all_destroyed_message(Request $request) 
    {
        $request->validate([
            'thread_id' => 'required|array',
        ]);

        foreach ($request->thread_id as $id) {
            $threads = MessageThread::findOrFail($id);
            $message = MessageParticipant::where('user_id', auth()->id())->where('thread_id', $threads->id)->withTrashed()->firstOrFail();
            $message->restore();
        }

        return redirect()->back()->with('warning', trans('messages.thread.restore'));
    }

    public function destroy_message_permanently($thread){
        $threads = MessageThread::where('slug',$thread)->first();
        $message = MessageParticipant::where('user_id', auth()->id())->where('thread_id', $threads->id)->withTrashed()->update([
            'deleted_for_receiver'=>  Carbon::now(),
           ]); 
        return redirect()->back()->with('danger', trans('messages.thread.permanent-delete'));
    }

    public function destroy_all_message_permanently(Request $request){
    
        $request->validate([
            'thread_id' => 'required|array',
        ]);
      
        foreach ($request->thread_id as $id) {
                      
           $threads = MessageThread::findOrFail($id);
           $message = MessageParticipant::where('user_id', auth()->id())->where('thread_id', $threads->id)->withTrashed()->update([
            'deleted_for_receiver'=>  Carbon::now(),
           ]);
        
       }
    
        return redirect()->route('admin.messages.trash_messages')->with('danger', trans('messages.thread.permanent-delete'));
    }
    public function destroy_all_sent_message(Request $request){
    
       
        $request->validate([
            'thread_id' => 'required|array',
        ]);
       
        foreach ($request->thread_id as $id) {  
            
            $threads = MessageThread::findOrFail($id);
            $message = MessageParticipant::where('thread_id', $threads->id)->withTrashed()->update([
                'deleted_for_sender'=>  Carbon::now(),
               ]); 
           


       }
    
        return redirect()->back()->with('danger', trans('messages.thread.deleted'));
    }


    public function addParticipant($id, $userId){
        $thread = MessageThread::findOrFail($id);
        if($thread->addParticipant($userId))
        {
            return redirect()->back()->with('success', 'Participant added successfully');
        } else {
            return redirect()->back()->with('danger', 'There was an error adding the participant');
        }

    }

    public function removeParticipant($id, $userId){
        $thread =  MessageThread::findOrFail($id);
        if($thread->removeParticipant($userId))
        {
            return redirect()->back()->with('success', 'Participant removed successfully');
        } else {
            return redirect()->back()->with('danger', 'There was an error removing the participant');
        }

    }

    public function star($thread){
        
        $thread =  MessageThread::findOrFail($thread);

        $starred = MessageParticipant::where('thread_id',$thread->id)->update([
            'starred'=> 1,
           ]); 

        if( $starred)
        {
            return redirect()->back()->with('success', 'Thread starred');
        } else {
            return redirect()->back()->with('danger', 'There was an error starring the thread');
        }

    }
    public function unstar($thread){
        
        $threads =  MessageThread::findOrFail($thread);
        $starred = MessageParticipant::where('thread_id',$threads->id)->update([
            'starred'=> 0,
           ]); 

        if( $starred)
        {
            return redirect()->back()->with('warning', 'Thread unstarred');
        } else {
            return redirect()->back()->with('danger', 'There was an error starring the thread');
        }

    }
}


