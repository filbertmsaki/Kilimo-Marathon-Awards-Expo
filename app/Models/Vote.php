<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;
    protected $fillable = [
        'agent',
        'nominee_id',
        'category_id',
    ];


    public function category()  {
        return $this->belongsTo(AwardCategory::class,'category_id');
    }
    public function nominee()  {
        return $this->belongsTo(AwardNominee::class,'nominee_id');
    }

}
