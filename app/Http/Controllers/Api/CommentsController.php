<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comments;

class CommentsController extends Controller
{
    public function createComment(Request $request){
        $comment = $request->comment;
        $blog_id = $request->blog_id;
        try{
            $comment = Comments::create([
                'commment' => $comment,
                'blog_id' => $blog_id
            ]);
            $status = 'success';
        }catch(\Exception $e) {
            $status = 'error';
        }
        return response()->json(['status' => $status], 200);
    }
}
