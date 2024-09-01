<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpoRegistration extends Model
{
    use HasFactory;
    protected $fillable = [
        'reference',
        'slug',
        'entry',
        'phonecode',
        'company_name',
        'service_name',
        'company_phone',
        'company_email',
        'contact_person_name',
        'contact_person_phone',
        'contact_person_email',
        'address',
        'company_details',
        'active',
        'paid',
        'transactionref'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->slug = unique_token();
            $model->reference = reference_no($model);
        });
    }

    public function scopeExpoExist($query,$company_name, $company_phone = null,  $contact_person_phone)
    {
        $currrentYear = date('Y');
        $qry =$query->where('company_name', $company_name);
        if (request()->has('company_phone')) {
            $qry->orWhere('company_phone', $company_phone);
        }
        return $qry->whereYear('created_at', '=', $currrentYear)->exists();
    }
}
