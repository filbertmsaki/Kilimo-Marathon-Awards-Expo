<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgriTourism extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'phone',
        'email',
        'age',
        'gender',
        'address',
        'activities',
        'emergency_contact',
        'emergency_phone',
        'additional_info',
        'agree_checkbox',
        'transactionref',
        'paid'
    ];

    protected $casts = [
        'activities' => 'array',
        'agree_checkbox' => 'boolean',
    ];

    public function scopeUserExist($query, )
    {
        $currrentYear = date('Y');
        $qry = $query->where('full_name', request()->has('full_name'));
        if (request()->has('phone')) {
            $qry->orWhere('phone', request()->has('phone'));
        }
        if (request()->has('email')) {
            $qry->orWhere('email', request()->has('email'));
        }
        return $qry->whereYear('created_at', '=', $currrentYear)->exists();
    }
}
