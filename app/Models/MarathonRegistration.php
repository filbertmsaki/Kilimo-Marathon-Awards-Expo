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
}
