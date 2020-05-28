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
   
        // get video cua cac users dang duoc user-loggedIn theo doi
    $list=Video::with('user')
        ->join('friends', 'friends.friend_id', '=', 'videos.video_id_user')
        ->where('friends.user_id', '=',$request->id )
        ->get();
       
        // $list1=array(); 
        // $test=User::find($request->id)->friendsOfMine()->get();
        // dd($test);
        // foreach($test as $value){
        //     $test2=Video::where('video_id_user',$value->id)->with('user')->get()->toArray();
        //     $list1=array_merge((array)$list1, (array)$test2);
        // }
        // arsort($list1); 
        // $list=(object)$list1;
        return response([
            'listVideo' => $list,
        ]);
    }
    public function getVideo2()
    {
        $list=Video::get();
        return $list;
    }
    public function upload(Request $request){
        $id=$request->id;
        // dd($id);
        $video_name = $request->file->getClientOriginalName();
        $request->file->move(public_path('video'), $video_name);
        $video_upload = Video::create([
            'video_id_user' => 3,
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
            'nameUserCmt' => 'toan',
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