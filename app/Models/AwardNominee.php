<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AwardNominee extends Model
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
        'category_id',
        'company_details',
        'vote',
        'verified',
    ];
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->slug = unique_token();
        });
    }

    public function award_voter()
    {
        return $this->belongsToMany(AwardVoters::class, 'award_nominee_award_voters');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function awardcategory()
    {
        return $this->belongsTo(AwardCategory::class, 'category_id');
    }
    public function vote()
    {
        return $this->hasMany(Vote::class);
    }

    public function getCurrentYearAttribute(){
        return date('Y');
    }

    public function scopeNomineeExist($query,$company_name,$category_id)
    {
        $currrentYear = date('Y');

        $award =$query->where('category_id', $category_id);
        if (request()->has('company_name')) {
            $award->where('company_name', $company_name);
        }
        return $award->whereYear('created_at', '=', $currrentYear)->exists();
    }
}
