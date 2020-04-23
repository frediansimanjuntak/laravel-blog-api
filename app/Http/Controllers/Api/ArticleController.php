<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ArticleResource;
use Illuminate\Support\Facades\Auth;
use App\Article;

class ArticleController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api')->except(['index', 'show']);
    }

    public function index() {
        $articles = ArticleResource::collection(Article::all());
        return response()->json(['success' => true, 'data' => $articles]);
    }

    public function store(Request $request){
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required'
        ]);

        $article = new Article;
        $article->title = $request->title;
        $article->description = $request->description;
        $article->user_id = Auth::user()->id;
        $article->save();

        $article = new ArticleResource($article);
        return response()->json(['success' => true, 'data' => $article]);
    }

    public function update(Request $request, Article $article){
        $user = Auth::user();
        if ($user->id != $article->user_id){
            return response()->json(['success' => false, 'message' => "You don't have permission"], 401);
        }

        $article->update($request->only(['title','description']));
        $article = new ArticleResource($article);
        return response()->json(['success' => true, 'data' => $article]);
    }

    public function show(Article $article) {
        $article = new ArticleResource($article);
        return response()->json(['success' => true, 'data' => $article]);
    }

    public function destroy(Request $request, Article $article){
        $user = Auth::user();
        if ($user->id != $article->user_id){
            return response()->json(['success' => false, 'message' => "You don't have permission"], 401);
        }
        $article->delete();
        return response()->json(['success' => true, 'message' => "delete success"]);
    }
}
