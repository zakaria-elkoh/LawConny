<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\PostResource;
use App\Http\Resources\User\UserPostResource;
use App\Http\Resources\User\UserProfileResource;
use App\Http\Resources\User\UserResource;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * get the small profiles of the users.
     */
    public function index(Request $request)
    {
        $users = User::where('id', '!=', $request->user()->id)->orderBy('id', 'desc')->paginate(5);

        if($users->isEmpty()){
            return response()->json(['status' => 'error', 'message' => 'No users found'], 404);
        }

        $response = [
            'status' => 'ok',
            'data' => UserResource::collection($users)
        ];

        return response()->json($response, 200);
    }

    public function getChattingPartners(Request $request)
    {

        $user_id = $request->user()->id;

        $usersSentTo = Message::select('receiver_id as user_id')
            ->where('sender_id', $user_id);

        $usersReceivedFrom = Message::select('sender_id as user_id')
            ->where('receiver_id', $user_id);

        $users = User::whereIn('id', $usersSentTo)
            ->orWhereIn('id', $usersReceivedFrom)
            ->distinct()
            ->get();

        $response = [
            'status' => 'ok',
            'data' => UserResource::collection($users)
        ];

        return response()->json($response, 200);
    }
    /**
     * get the followers
     */
    public function getMyFollowers(Request $request)
    {
        $followers = $request->user()->followers()->with('followers')->get();

        if ($followers->isEmpty()) {
            return response()->json(['status' => 'error', 'message' => 'This user has no followers'], 404);
        }

        $response = [
            'status' => 'ok',
            'data' => UserPostResource::collection($followers)
        ];

        return response()->json($response, 200);
    }
    /**
     * get who I am following
     */
    public function getMyFollowing(Request $request)
    {
        $following = $request->user()->following()->get();

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

    public function showUserByUsername(User $user)
    {

        $response = [
            'status' => 'ok',
            'data' => $user
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
