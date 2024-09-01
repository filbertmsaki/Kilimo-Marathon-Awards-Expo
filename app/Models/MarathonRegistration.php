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
        'reference'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->slug = unique_token();
            $model->reference = reference_no($model);
        });
    }
    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
    public function scopeRunnerExist($query, $email, $phone)
    {
        $currrentYear = date('Y');
        $qry = $query->where('email', $email)
            ->where('phone', $phone);
        return $qry->whereYear('created_at', '=', $currrentYear)->exists();
    }
}
