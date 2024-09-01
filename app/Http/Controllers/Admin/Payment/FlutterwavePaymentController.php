<?php

namespace App\Http\Controllers\Admin\Payment;

use App\Http\Controllers\Controller;
use App\Models\Payment\FlutterwaveModel;
use Illuminate\Http\Request;

class FlutterwavePaymentController extends Controller
{
    public function index()
    {
        // Fetch all payments
        $payments = FlutterwaveModel::latest()->get();
        // Return the view with payments data
        return view('admin.payment.flutterwave', compact('payments'));
    }
}
