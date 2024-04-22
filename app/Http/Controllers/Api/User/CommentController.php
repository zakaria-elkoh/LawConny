<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\User\CommentResource;
use App\Models\Post;

class CommentController extends Controller
{
    /**
     * return the comments of an post.
     */
    public function index()
    {
        return response()->json('hello');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request)
    {

        $comment = Comment::create([
            'body' => $request->comment,
            'post_id' => $request->post_id,
            'user_id' => $request->user()->id,
        ]);

        $response = [
            'message' => 'Comment added with success',
            'data' => new CommentResource($comment),
        ];

        return response()->json($response, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
