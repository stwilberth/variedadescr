<?php

namespace App;

use App\Role;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    public function AutorizaRoles($roles)
    {
        if ($this->hasAnyRoles($roles)) {
            return true;
        } else{
            return false;
        }
    }
    public function hasAnyRoles($roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
               return $this->hasRole($role);
            }
        } else {
            return $this->hasRole($roles);
        }
        return false;
        
    }

    public function hasRole($role)
    {
        if ($this->roles()->where('nombre', $role)->first()) {
           return true;
        }
        return false;
    }



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
