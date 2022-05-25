<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\MailDispatched;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Swift_TransportException;

class MailController extends Controller
{
    /**
     * Display a listing of the mail.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        return view('admin.mails.inbox');
    }

    /**
     * Show the form for creating a new mail.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $usersTbl = DB::table('users')->select('email')->groupBy('email');
        $subscriberTbl = DB::table('subscribers')->select('email')->groupBy('email');
        $awardTbl = DB::table('award_nominees')->select('email')->groupBy('email');
        $contactTbl = DB::table('contact_us')->select('email')->groupBy('email');
        $maratthonTbl = DB::table('marathon_registrations')->select('email')->groupBy('email');
        $to = $usersTbl->union($subscriberTbl)
                        ->union($awardTbl)
                        ->union($contactTbl)
                        ->union($maratthonTbl)
                        ->get();
        $cc = $usersTbl->union($subscriberTbl)
                        ->union($awardTbl)
                        ->union($contactTbl)
                        ->union($maratthonTbl)
                        ->get();
        $bcc = $usersTbl->union($subscriberTbl)
                        ->union($awardTbl)
                        ->union($contactTbl)
                        ->union($maratthonTbl)
                        ->get();
       
        return view('admin.mails.compose',compact(['cc','to','bcc']));
    }

    /**
     * Store a newly created mail in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $request->validate([
            'subject' => 'required',
            'body' => 'required',
            'recipients' => 'required|array',
        ]);

        $data = [
            'subject' => $request->subject,
            'body' => $request->body,
            'cc' => $request->cc,
            'bcc' => $request->bcc,
            'attachments' => $request->file('attachments')
         ];
    
        try{

            foreach($request->recipients as $email){
                
              
                $mail = new MailDispatched($data,$email);
                Mail::send($mail);
            
            }

           

        }catch(Swift_TransportException $ex){
            return redirect()->back()->with('danger','Message sent Fail');  
        }
        if (count(Mail::failures()) > 0) {
             foreach(Mail::failures() as $email_address) {
                $this->statusdesc = $email_address;
             }
 
        }else{
 
           $this->statusdesc  =   "Message sent Succesfully";
           $this->statuscode  =   "1";
        }
        // return response()->json(compact('this'));
        return redirect()->back()->with('success','Message sent Succesfully');  

    }

    /**
     * Display the specified mail.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified mail.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified mail in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
        /**
     * Remove the All mail from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_all($id)
    {
        //
    }

    public function sent()
    {
        return view('admin.mails.sent');
    }

    public function trash()
    {
        return view('admin.mails.trash');
    }
    
}
