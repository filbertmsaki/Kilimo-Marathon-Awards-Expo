<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class AwardCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug', 'name_in_swahili',
        'description',
    ];
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->slug =unique_token();
            $model->name = ucwords(strtolower($model->name));
            $model->name_in_swahili = ucwords(strtolower($model->name_in_swahili));
        });
        static::updating(function ($model) {
            $model->name = ucwords(strtolower($model->name));
            $model->name_in_swahili = ucwords(strtolower($model->name_in_swahili));
        });
    }
    public function award_nominee()
    {

        return $this->hasMany(AwardNominee::class, 'category_id');
    }
    public function current_year_nominee()
    {
        $currrentYear = date('Y');
        return $this->award_nominee()->whereYear('created_at', '=', $currrentYear);
    }
    public function nominated()
    {

        return $this->award_nominee()->where('verified', '1')->get();
    }
    public function scopeNominees(Builder $query)
    {

        return $query->join('award_nominees', 'award_categories.id', '=', 'award_nominees' . '.category_id')
            ->where('award_nominees.verified', '1')
            ->groupBy(
                'award_categories.id',
                'award_categories.slug',
                'award_categories.name',
                'award_categories.name_in_swahili',
                'award_categories.description',
                'award_categories.created_at',
                'award_categories.updated_at',
            )
            ->select('award_categories' . '.*');
    }
}
