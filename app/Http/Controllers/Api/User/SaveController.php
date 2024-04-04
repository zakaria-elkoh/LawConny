<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class SaveController extends Controller
{

    public function storeSave(Request $request, Post $post)
    {

        $post->saves()->sync($request->user()->id);

        return response()->json("saved" . $post, 201);
    }

    public function removeSave(Request $request, Post $post)
    {
        $post->saves()->detach($request->user()->id);

        return response()->json("unsaved" . $post, 200);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
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
    public function show(string $id)
    {
        //
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
