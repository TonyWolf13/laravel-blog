<?php

namespace App\Http\Controllers;

use App\Http\Requests\LikeRequest;
use App\Http\Resources\LikeResource;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->morphValidation($request->query());

        return LikeResource::collection(
            Like::with('user')
                ->where('likable_id', $request->query('likable_id'))
                ->where('likable_type', $request->query('likable_type'))
                ->orderBy('id', 'DESC')
                ->paginate(10)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LikeRequest $request)
    {
        $this->morphValidation($request->all());
        
        $model = $request->likable_type::where('id', $request->likable_id)->first();

        if (!$model) {
            throw ValidationException::withMessages([
                'likable_id' => 'This record does not exist.'
            ]);
        }

        /** @var \App\Models\User */ 
        $user = Auth::user();
        $like = $user->likes()
            ->where('likable_id', $request->likable_id)
            ->where('likable_type', $request->likable_type)
            ->first();

        if ($like) {
            throw ValidationException::withMessages([
                'likable_id' => 'You already liked this resource.'
            ]);
        }

        return new LikeResource($model->likes()->create([
            'type' => $request->type,
            'user_id' => $user->id 
        ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LikeRequest $request, Like $like)
    {
        $like->update([
            'type' => $request->type,
        ]);
        return $like;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Like $like)
    {
        $like->delete();
        return ['success' => true];
    }

    private function morphValidation(string|array|null $data) : void 
    {
        Validator::make($data, [
            'likable_id' => ['required','integer'],
            'likable_type' => [
                'required',
                Rule::in([Article::class, Comment::class]),
            ],
        ])->validate();
    }
}
