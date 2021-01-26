<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'total_paid_leave', 'total_sick_leave'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
         'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*
    * associations
    */ 
    public function roles() {
        return $this->belongsToMany(Role::class, 'user_role');
    }

    public function managers() {
        return $this->belongsToMany(User::class, 'user_manager', 'user_id', 'manager_id')
            ->select(['id','name','email']);
    }

    public function subordinateUsers() {
        return $this->belongsToMany(User::class, 'user_manager', 'manager_id', 'user_id')
            ->select(['id','name','email']);
    }

    /*
    * instance methods
    */ 
    public function isHr() {
        return in_array('hr', $this->roles()->pluck('name')->all());
    }

    public function isAdmin() {
        return in_array('admin', $this->roles()->pluck('name')->all());
    }

    public function isAdminOrHr() {
        return $this->isAdmin() || $this->isHr();
    }
}
