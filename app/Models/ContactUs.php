<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    use HasFactory;
    protected $fillable=[
        'first_name',
        'last_name',
        'phone',
        'email',
        'message',
        'seen_at'
    ];
}
