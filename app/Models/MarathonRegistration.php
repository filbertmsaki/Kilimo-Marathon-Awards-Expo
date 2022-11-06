<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarathonRegistration extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $fillable = [
        'slug',
        'transactionref',
        'first_name',
        'last_name',
        'gender',
        'age',
        'phonecode',
        'phone',
        'email',
        'event',
        't_shirt_size',
        'address',
        'paid',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->slug = unique_token();
        });
    }
    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
    public function scopeRunnerExist($query,$first_name,$last_name,$phone)
    {
        $currrentYear = date('Y');
        $qry =$query->where('first_name', $first_name)
                    ->where('last_name', $last_name)
                    ->where('phone', $phone);
        return $qry->whereYear('created_at', '=', $currrentYear)->exists();
    }
}
