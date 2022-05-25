<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'site_name',
        'site_logo',
        'site_icon',
        'site_tagline',
        'site_url',
        'site_address',
    ];

}
