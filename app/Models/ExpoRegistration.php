<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpoRegistration extends Model
{
    use HasFactory;
    protected $fillable = [
        'slug',
        'company_name',
        'contact_person_name',
        'contact_person_phone',
        'contact_person_email',
        'business_details',
    ];
}
