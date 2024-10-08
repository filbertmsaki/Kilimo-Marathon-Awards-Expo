<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
    ];
    public function getRouteKeyName(){
        return 'slug';
    }
    
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }


    public function roles() {

        return $this->belongsToMany(Role::class,'roles_permissions');
            
    }
     
    public function users() {
     
        return $this->belongsToMany(User::class,'users_permissions')->withPivot('permission_id');
            
    }
}
