<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function storeLike(Request $request, Post $post)
    {

        $post->likes()->attach($request->user()->id);

        $post->update([
            'total_likes' => $post->total_likes + 1
        ]);

        return response()->json("liked" . $post, 201);
    }   

    public function removeLike(Request $request, Post $post)
    {
        $post->likes()->detach($request->user()->id);

        $post->update([
            'total_likes' => $post->total_likes - 1
        ]);

        return response()->json("deleted with success" . $post, 201);
    }


    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Like $like)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Like $like)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Like $like)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Like $like)
    {
        //
    }
}
