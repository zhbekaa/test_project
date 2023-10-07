<?php

namespace App\Http\Controllers;

use App\Models\Tag;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class ArticleController extends Controller
{
    public function listWelcome()
    {
        $articles = Article::orderBy("created_at", "desc")->simplePaginate(6);
        return view('welcome', ['articles' => $articles]);
    }

    public function list(Request $request)
    {
        if ($request->input('tag')) {
            $tag = Tag::find($request->input('tag'));
            $articles = $tag->articles()->orderBy("created_at", "desc")->simplePaginate(10);
           
        } else {
            $articles = Article::orderBy("created_at", "desc")->simplePaginate(10);
        }
        
        
        return view('articles', ['articles' => $articles]);
    }
    public function details(Request $request)
    {
        $article = Article::find($request->id);
        $comments = $article->comments->sortByDesc("created_at");
        $tags = $article->tags;
        return view('article', ['article' => $article, 'comments' => $comments, 'tags' => $tags]);
    }
    public function postLike(Request $request) {
        $article = Article::find($request->id);
        $article->like++;
        $article->save();
        
        return response()->json(['success'=>strval($article->like)]);
    }
    
}
