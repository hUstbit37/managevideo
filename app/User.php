<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        'name', 'email', 'password', 'user_avatar',
    ];
    public function video()
    {
       return $this->hasMany('App\Video', 'video_id_user', 'id');
    }
    public function comment()
    {
       return $this->hasMany('App\Comment', 'comment_id_user', 'id');
    }
    
    public function comment_s(){
        return $this->hasManyThrough('App\Comment', 'App\Video', 'video_id_user', 'comment_id_video', 'id');
    }

    public function friendsOfMine()
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id');
    }
    public function friendOf()
    {
        return $this->belongsToMany(User::class, 'friends', 'friend_id', 'user_id');
    }
    public function isFriend($userId) 
    {
        return (boolean) $this->friendsOfMine()->where('friend_id', $userId)->first(['id']);
    }
    public function friend(){
        return $this->hasMany('App\Friend', 'user_id','id');
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