<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function postComment(Request $request)
    {

        if (!$request->subject || !$request->content) return response()->json('ValidationException');
        $data = [
            'subject' => $request->subject,
            'content' => $request->content,
            'article_id' => $request->articleId,
        ];
        $comment = Comment::create($data);

        
        return response()->json($comment);
    }
   
}
