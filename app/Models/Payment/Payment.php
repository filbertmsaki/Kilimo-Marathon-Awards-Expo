<?php

namespace App\Models\Payment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'slug','customer_name','phone','amount',
        'reference','company_ref','pnrid',
        'ccapproval','trans_id','transaction_token','status',
        'transaction_result_description','mobile_payment_request'
    ];
}
