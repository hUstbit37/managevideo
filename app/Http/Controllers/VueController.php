<?php

namespace App\Http\Controllers;

use App\Video;
use Illuminate\Http\Request;
use TeamTNT\TNTSearch\TNTSearch;
use Auth;
use App\User;
use App\Comment;
use App\Friend;

class VueController extends Controller
{
    public function index()
    {
        return view('VuePage/index');
    }
    public function listVideo(Request $request)
    {
        $h = User::find($request->id)->friendsOfMine()->get();

        $end = [];
        foreach ($h as $value) {
            $k = $value->id;
            $end =  array_merge($end, (array) $k);
        }
        // dd($end);
        $list = Video::getVideoFriend($request->id)->skip(0)->take(2)->get()->toArray();
        // dd($list);
        return response([
            'list' => $list,
            'friendListId' => $end
        ]);
    }
    public function loadMoreVideo(Request $request)
    {
        $page = $request->page;
        $id = $request->id;
        $start = ($page - 1) * 2;
        $list = Video::getVideoFriend($id)->skip($start)->take(2)->get();
        return response([
            'list' => $list,
        ]);
    }
    public function showUserVideo(Request $request)
    {
        // dd($request->id);
        $listUserVideo = User::find($request->id)->video()->orderBy('created_at', 'desc')->get();
        return $listUserVideo;
    }
    public function upload(Request $request)
    {
        if ($request->fileThumbnail) {
            $thumbnail = $request->fileThumbnail->getClientOriginalName();
            $request->fileThumbnail->move(public_path('video/thumbnails'), $thumbnail);
        }
        if ($request->fileVideo) {
            $video_path = $request->fileVideo->getClientOriginalName();
            $request->fileVideo->move(public_path('video'), $video_path);
            $video_upload = Video::create([
                'video_id_user' => $request->id,
                'video_path' => $video_path,
                'video_name' => $request->fileName,
                'video_thumbnail' => $thumbnail,
                'like' => 0,
                'view' => 0
            ]);
        } else {
            $video_upload = Video::find($request->video_id);
            $video_upload->video_name = $request->fileName;
            $video_upload->video_thumbnail = $thumbnail;
            $video_upload->save();
        }
        return response([
            'video_upload' => $video_upload
        ]);
    }
    public function deleteVideo($id)
    {
        // dd($id);
        Video::find($id)->comment()->delete();
        $a = Video::find($id)->delete();
        // dd($a);
        return $a;
    }
    public function addCmt(Request $request, $id)
    {
        $unitCmt = new Comment();
        $unitCmt->comment_content = $request->comment_content;
        $unitCmt->comment_id_video = $request->comment_id_video;
        $unitCmt->comment_id_user = $request->comment_id_user;
        $unitCmt->save();
        return response([
            'mess' => 'Success',
            'unitCmt' => $unitCmt,
        ]);
    }
    public function commentPaganationVue(Request $request)
    {
        $page = $request->page;
        $id = $request->id;
        $start = ($page - 1) * 4;
        $cmt_count = Video::find($id)->comment()->count();
        // $cmt = Video::find($id)->comment()->orderBy('created_at', 'desc')->skip(0)->take($start)->get();
        $cmt = Comment::where('comment_id_video', $id)->with('user')->orderBy('created_at', 'desc')->skip($start)->take(4)->get();
        // dd($cmt);

        return response([
            'message' => 'success',
            'cmt' => $cmt,
            'cmt_count' => $cmt_count,
        ]);
    }
    public function sub(Request $request)
    {
        $check1 = Friend::where('user_id', $request->user_id)->where('friend_id', $request->friend_id)->first();
        if ($check1) {
            $a = Friend::where('user_id', $request->user_id)->where('friend_id', $request->friend_id)->delete();
            return response([
                'check' => true
            ]);
        } else {
            $b = Friend::firstOrCreate($request->all());
            return response([
                'check' => false
            ]);
        }
    }
    public function search(Request $request)
    {
        $key = $request->search;
        $kq = Video::search($key)->get();
        $tnt = new TNTSearch;
        $kq = $kq->map(function ($article) use ($key, $tnt) {
            $article->video_name = $tnt->highlight($article->video_name, $key, 'b');
            return $article;
        });
        $kq_count = $kq->count();

        $ka = Video::where('video_name', 'like', '%' . $key . '%')->with('user')->get();
        $ka_count = $ka->count();
        // dd($ka->toArray());
        return response([
            'kq' =>  $ka,
            'kq_count' => $ka_count,
        ]);
    }
}
