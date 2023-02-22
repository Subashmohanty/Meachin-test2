<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Comments;
use DB;
class BlogsController extends Controller
{
    public function createBlogs(Request $request)
    {
        // $this->validate($request, [
        //     'blog_name' => 'required|min:4',
        // ]);
        $user_id = auth()->user()->id;
        try{
            $user = Blog::create([
                'title' => $request->blog_name,
                'posts' => $request->posts,
                'user_id'=>$user_id
            ]);
            $status = 'success';
        }catch(\Exception $e) {
            $status = 'error';
        }
        return response()->json(['status' => $status], 200);
    }
    public function updateBlogs(Request $request)
    {
        $title = $request->title;
        $posts = $request->posts;
        $id = $request->id;
        $user_id = auth()->user()->id;
        try{
            DB::table('blogs')->where('id', $id)->update(['title' => $title,'posts' => $posts,'user_id'=>$user_id]);
            $status = 'success';
        }catch(\Exception $e) {
            $status = 'error';
        }
        return response()->json(['status' => $status], 200);
    }
    public function deleteBlogs(Request $request)
    {
        $id = $request->id;
        try{
            $Blog = Blog::find( $id );
            $Blog->delete();
            $status = 'success';
        }catch(\Exception $e) {
            $status = 'error';
        }
        return response()->json(['status' => $status], 200);
    }
    public function showBlogs(Request $request)
    {
        $id = (empty($request->id)) ? '' : $request->id;
        $user_id = auth()->user()->id;
        if(empty($id)){
            $Blog = Blog::where(['user_id'=>$user_id])->get();
        }else{
            $Blog = Blog::where(['user_id'=>$user_id,'user_id'=>$user_id])->get();
        }
        $status = 'success';
        return response()->json(['status' => $status,'data'=>$Blog], 200);
    }
    public function showBlogcomments(Request $request)
    {
        $token = auth()->user()->roles;
        $user_id = auth()->user()->id;
        if($token == 'Write'){
            $posts = Blog::with('Comments')->where('user_id',$user_id)->get();
        }else{
            $posts = Blog::with('Comments')->get();
        }
        return response()->json(['data' => $posts], 200);
    }
}
