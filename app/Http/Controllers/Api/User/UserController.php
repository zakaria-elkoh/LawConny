<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\PostResource;
use App\Http\Resources\User\UserPostResource;
use App\Http\Resources\User\UserProfileResource;
use App\Http\Resources\User\UserResource;
use App\Models\Follower;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * get the small profiles of the users.
     */
    public function index()
    {
        $users = User::paginate(10);

        $response = [
            'status' => 'ok',
            'data' => UserProfileResource::collection($users)
        ];

        return response()->json($response, 200);
    }
    /**
     * get the followers
     */
    public function followers(User $user)
    {
        $followers = $user->followers()->with('followers')->paginate();
        $response = [
            'status' => 'ok',
            'followers' => UserPostResource::collection($followers)
        ];

        return response()->json($response, 200);
    }
    /**
     * get who I am following
     */
    public function following(User $user)
    {
        $following = $user->following()->get();
        $response = [
            'status' => 'ok',
            'following' => UserPostResource::collection($following)
        ];

        return response()->json($response, 200);
    }
    /**
     * get the posts I saved
     */
    public function savedPosts(User $user)
    {
        $saved_posts = $user->saves()->get();
        $response = [
            'status' => 'ok',
            'saved_posts' => PostResource::collection($saved_posts)
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
     * get the profile of a user.
     */
    public function show(User $user)
    {
        $response = [
            'status' => 'ok',
            'data' => new UserProfileResource($user)
        ];

        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove a user.
     */
    public function destroy(string $id)
    {
        //
    }
}
