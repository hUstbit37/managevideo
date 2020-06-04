<?php

namespace App\Http\Controllers;
use App\Video;
use Illuminate\Http\Request;
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
        $list=Video::getVideoFriend($request->id)->skip(0)->take(2)->get()->toArray();
        // dd($list);
        return response([
            'list'=>$list,
        ]);
    }
    public function loadMoreVideo(Request $request){
        $page=$request->page;
        $id=$request->id;
        $start = ($page - 1) * 2;
        $list=Video::getVideoFriend($id) ->skip($start)->take(2)->get();
        return response([
            'list'=>$list,
        ]);
    }
    public function getVideo2()
    {
        $list=Video::get();
        return $list;
    }
    public function upload(Request $request){
        // $id=$request->id;
        // dd($request->id);
        $video_name = $request->file->getClientOriginalName();
        $request->file->move(public_path('video'), $video_name);
        $video_upload = Video::create([
            'video_id_user' => 1,
            'video_name' => $video_name
        ]);
        $listVideo=Video::orderBy('created_at', 'desc')->get();
        return response([
            'listVideo'=>$listVideo,
            'video_upload'=> $video_upload
        ]);
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
        $cmt=Comment::where('comment_id_video', $id)->with('user')->orderBy('created_at', 'desc')->skip(0)->take($start)->get();
        // dd($cmt);

        return response([
            'message' => 'success',
            'cmt' => $cmt,
            'cmt_count' => $cmt_count,
        ]);
    }
}