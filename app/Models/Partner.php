<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;
    protected $fillable = [
        'slug',
        'name',
        'description',
        'image_url',
        'status',
         'order',
    ];
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->slug = unique_token();
            $model->name = ucwords(strtolower($model->name));
        });
        static::updating(function ($model) {
            $model->name = ucwords(strtolower($model->name));
        });
    }
}
