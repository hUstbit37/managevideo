<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'user_avatar',
    ];
    public function video()
    {
       return $this->hasMany('App\QlVideo', 'video_id_user', 'id');
    }
    public function comment()
    {
       return $this->hasMany('App\Comment', 'comment_id_user', 'id');
    }
    
    public function comment_s(){
        return $this->hasManyThrough('App\Comment', 'App\QlVideo', 'comment_id_user', 'comment_id_video', 'id');
    }
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