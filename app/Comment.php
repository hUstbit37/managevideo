<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['comment_content', 'comment_id_video', 'comment_id_user'];

    public function user()
    {
        return $this->belongsTo('App\User', 'comment_id_user', 'id');
    }
    public function video()
    {
        return $this->belongsTo('App\QlVideo', 'comment_id_video', 'id');
    }
}