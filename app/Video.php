<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = ['video_name', 'video_thumbnail', 'video_id_user'];

    public function user()
    {
        return $this->belongsTo('App\User', 'video_id_user', 'id');
    }
    public function comment()
    {
        return $this->hasMany('App\Comment', 'comment_id_video', 'id');
    }
}