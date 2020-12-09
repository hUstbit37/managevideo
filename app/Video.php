<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Video extends Model
{
    use Searchable;
    public $asYouType = true;
    public function searchableAs()
    {
        return 'videos_index';
    }

    protected $fillable = ['video_name', 'video_id_user', 'video_path', 'video_thumbnail', 'like', 'view'];

    public static function getVideoFriend($id)
    {
        return Video::with('user', 'comment')
            ->join('friends', 'friends.friend_id', '=', 'videos.video_id_user')
            ->where('friends.user_id', '=', $id)
            ->select('videos.*', 'friends.friend_id', 'friends.user_id')
            ->orderBy('videos.created_at', 'desc');
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'video_id_user', 'id');
    }
    public function comment()
    {
        return $this->hasMany('App\Comment', 'comment_id_video', 'id');
    }
}
