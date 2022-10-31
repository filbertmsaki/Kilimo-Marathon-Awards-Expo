<?php

namespace App\Models\Payment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PushPayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'slug','result', 'resultexplanation', 'transactiontoken',
        'transactionref', 'customername', 'customercredit',
        'transactionapproval', 'transactioncurrency', 'transactionamount',
        'fraudalert', 'fraudexplnation', 'transactionnetamount',
        'transactionsettlementdate', 'transactionrollingreserveamount',
        'transactionrollingreservedate', 'customerphone', 'customercountry',
        'transactionfinalcurrency','transactionfinalamount',
        'customeraddress', 'customercity', 'customerzip', 'mobilepaymentrequest', 'accref',
        'status','customercredittype','accref'
    ];
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->slug = unique_token();
        });
    }
}
