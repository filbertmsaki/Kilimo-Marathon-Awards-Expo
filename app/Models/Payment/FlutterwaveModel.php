<?php

namespace App\Models\Payment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FlutterwaveModel extends Model
{
    use HasFactory;
    protected $table = 'flutterwaves';

    protected $fillable = [
        'payable_id',
        'payable_type',
        'reference',
        'amount',
        'currency',
        'charged_amount',
        'charged_currency',
        'transaction_id',
        'status',
        'flw_reference',
        'order_reference',
        'payment_plan',
        'payment_page',
        'payent_created_at',
        'appfee',
        'merchantfee',
        'merchantbearsfee',
        'charge_type',
        'customer_phone',
        'customer_full_name',
        'customer_email',
        'customer_accountId',
        'entity_card6',
        'entity_card_last4',
        'entity_card_country_iso',
        'event_type'
    ];

    protected $casts = [
        'payent_created_at' => 'datetime',
    ];
    public $incrementing = false;
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
        static::updating(function ($model) {});
    }


    public function payable()
    {
        return $this->morphTo();
    }
}
