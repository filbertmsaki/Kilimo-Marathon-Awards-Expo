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
        'transaction_id',
        'reference',
        'flw_reference',
        'device_fingerprint',
        'amount',
        'currency',
        'charged_amount',
        'charged_currency',
        'app_fee',
        'merchant_fee',
        'processor_response',
        'auth_model',
        'ip',
        'narration',
        'status',
        'payment_type',
        'payent_created_at',
        'customer_phone_number',
        'customer_name',
        'customer_email',
        'card_first_6digits',
        'card_last_4digits',
        'card_issuer',
        'card_country',
        'card_type',
        'card_expiry',
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
