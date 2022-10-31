<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpoRegistration extends Model
{
    use HasFactory;
    protected $fillable = [
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
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->slug = unique_token();
        });
    }

    public function scopeExpoExist($query,$company_name, $company_phone = null, $company_email = null, $contact_person_phone, $contact_person_email = null)
    {
        $currrentYear = date('Y');
        $qry =$query->where('company_name', $company_name);

        if (request()->has('company_phone')) {
            $qry->where('company_phone', $company_phone);
        }
        if (request()->has('company_email')) {
            $qry->orWhere('company_email', $company_email);
        }

        if (request()->has('contact_person_phone')) {
            $qry->orWhere('contact_person_phone', $contact_person_phone);
        }
        if (request()->has('contact_person_email')) {
            $qry->orWhere('contact_person_email', $contact_person_email);
        }
        return $qry->whereYear('created_at', '=', $currrentYear)->exists();
    }
}
