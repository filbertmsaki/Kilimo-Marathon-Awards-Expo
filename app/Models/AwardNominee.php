<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AwardNominee extends Model
{
    use HasFactory;
    protected $fillable = [
        'slug',
        'full_name',
        'company_phone',
        'company_email',
        'contact_person_name',
        'mobile',
        'email',
        'address',
        'company_individual',
        'company_details',
        'category_id',
        'vote',
        'verified',
    ];

    public function award_voter(){
        return $this->belongsToMany(AwardVoters::class, 'award_nominee_award_voters');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function awardcategory(){
        return $this->belongsTo(AwardCategory::class, 'category_id');
    }
    public function vote(){
        return $this->hasMany(Vote::class);
    }
}
