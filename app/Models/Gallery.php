<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;
    protected $fillable = [
        'slug',
        'title',
        'event',
        'description',
        'image_url',
    ];
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->slug =unique_token();
            $model->title = ucwords(strtolower($model->title));
        });
        static::updating(function ($model) {
            $model->title = ucwords(strtolower($model->title));
        });
    }
}
