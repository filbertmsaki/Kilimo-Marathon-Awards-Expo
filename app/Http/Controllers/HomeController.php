<?php

namespace App\Http\Controllers;

use App\Models\Payment\Dpo;
use App\Models\Payment\DpoGroup;
use App\Models\Payment\Payment;
use App\Models\Payment\PushPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;


class HomeController extends Controller
{
    const CALLBACK_URL = '/callback';
    const BACK_URL = '/canceled';
    const DECLINED_URL = '/declined';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        abort(401);
        return view('home');
    }


}
