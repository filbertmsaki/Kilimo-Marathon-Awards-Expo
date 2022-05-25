<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AwardMarathonSetting extends Model
{
    use HasFactory;
    protected $fillable =[
        'vote',
        'vote_time_remain',
        'awards_registration',
        'awards_registration_time_remain',
        'marathon_registration',
        'marathon_registration_time_remain',
    ];
}
