<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $request)
    {
        Validator::make($request->all(), [
            'commentable_id' => ['required','integer'],
            'commentable_type' => [
                'required',
                Rule::in([Article::class, Comment::class]),
            ],
        ])->validate();

        $model = $request->commentable_type::where('id', $request->commentable_id)->first();

        if (!$model) {
            throw ValidationException::withMessages([
                'commentable_id' => 'This record does not exist.'
            ]);
        }
        
        return $model->comments()->create([
            'body' => $request->body,
            'user_id' => Auth::user()->id 
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
