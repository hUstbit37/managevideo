<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = ['video_name', 'video_thumbnail', 'video_id_user'];
}