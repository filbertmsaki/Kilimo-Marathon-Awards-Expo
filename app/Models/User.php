<?php

namespace App\Models;

use App\Models\Message\Thread;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\HasPermissionsTrait;
use App\Traits\HasMessagesTrait;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasPermissionsTrait,HasMessagesTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'slug',
        'name',
        'first_name',
        'last_name',
        'mobile',
        'photo',
        'address',
        'otp',
        'email',
        'password',
        'last_login',
        'last_login_ip',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function getRouteKeyName(){
        return 'slug';
    }
    public function profile(){
        return $this->hasMany(Profile::class);
    }
    public function permissions() {

        return $this->belongsToMany(Permission::class,'users_permissions')->withPivot('permission_id');
            
    }
    public function roles() {

        return $this->belongsToMany(Role::class,'users_roles');
            
    }

    public function threads() {
        return $this->belongsToMany(Thread::class, 'participants', 'user_id', 'thread_id');
    }

   
}
