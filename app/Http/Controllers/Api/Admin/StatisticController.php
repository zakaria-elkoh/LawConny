<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        

        $total_users = User::count();
        $total_posts = Post::count();
        $total_comments = Comment::count();
        // $total_likes = User::sum('total_likes');
        // $total_comments = User::sum('total_comments');
        // $total_lawyers = User::where('is_lawyer', true)->count();

        $response = [
            'status' => 'ok',
            'data' => [
                'total_users' => $total_users,
                'total_posts' => $total_posts,
                // 'total_likes' => $total_likes,
                'total_comments' => $total_comments,
                // 'total_lawyers' => $total_lawyers
            ]
        ];

        return response()->json($response, 200);
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
