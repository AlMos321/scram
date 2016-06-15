<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
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

    public static function boot()
    {


        parent::boot();


        static::updating(function ($post) {
            if((strlen($post->password) >= 6 && strlen($post->password) <= 10)){
                $post->password = bcrypt($post->password);
            }
        });
    }
}
