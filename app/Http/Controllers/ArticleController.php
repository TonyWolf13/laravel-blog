<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Article::query()
            ->withCount('comments');

        if ($user_id = $request->query('user_id')) {
            $query->where('user_id', $user_id);
        } else {
            $query->with('user');
        }

        $query->orderBy(
            $request->query('sort_name', 'created_at'),
            $request->query('sort_type', 'DESC')
        );

        return ArticleResource::collection($query->paginate($request->query('limit', 10)));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleRequest $request)
    {
        
        // $article = new Article();
        // $article->title = $request->input('title');
        // $article->description = $request->input('description', '');
        // $article->content = $request->input('content', '');
        // $article->thumbnail = $request->input('thumbnail');
        // $article->banner = $request->input('banner');
        // $article->publish_at = $request->input('publish_at');
        // $article->save();
        
        // $article = Article::create(
        //     array_merge(
        //         [
        //             'user_id'=>$request->user()->id
        //         ],
        //         $request->validated()
        //     )
        // );
        
        //$article->user_id = Auth::user()->id;
        //$article->user_id = auth()->user()->id;
        // $article->user_id = $request->user()->id;
        // $article->save();
        
        $article = Article::create($request->validated());
        $article->load('user');
        return new ArticleResource($article);
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        $article->load(['user']);
        return new ArticleResource($article);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ArticleRequest $request, Article $article)
    {
        $article->update($request->validated());
        $article->load('user');
        return new ArticleResource($article);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return ['success' => true];
    }
}
