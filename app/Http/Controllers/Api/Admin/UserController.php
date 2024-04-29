<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\LawyerResource;
use App\Http\Resources\User\PostResource;
use App\Http\Resources\User\UserPostResource;
use App\Http\Resources\User\UserProfileResource;
use App\Http\Resources\User\UserResource;
use App\Models\Message;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * get the small profiles of the users.
     */
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(10);

        $response = [
            'status' => 'ok',
            'data' => UserResource::collection($users)
        ];

        return response()->json($response, 200);
    }

    public function deletePost(Post $post) {
        $post->delete();

        $response = [
            'status' => 'ok',
            'message' => 'Post has been deleted'
        ];

        return response()->json($response, 200);
    }

    public function getPosts()
    {
        $posts = Post::with('user', 'tags')->paginate(5);

        $response = [
            'status' => 'ok',
            'data' => PostResource::collection($posts),
            'pagination' => [
                'current_page' => $posts->currentPage(),
                'per_page' => $posts->perPage(),
                'total_pages' => ceil($posts->total() / $posts->perPage()),
            ]
        ];

        return response()->json($response, 200);
    }

    public function getLawyers()
    {

        $lawyers = User::whereHas('roles', function ($query) {
            $query->where('title', 'lawyer');
        })->with('roles')->paginate(5);

        $response = [
            'status' => 'ok',
            'data' => LawyerResource::collection($lawyers),
            'pagination' => [
                'current_page' => $lawyers->currentPage(),
                'per_page' => $lawyers->perPage(),
                'total_pages' => ceil($lawyers->total() / $lawyers->perPage()),
            ]
        ];

        return response()->json($response, 200);
    }

    public function searchLawyers()
    {

        $searchValue = request()->query('searchValue');

        $lawyers = User::whereHas('roles', function ($query) {
            $query->where('title', 'lawyer');
        })->where('name', 'like', '%' . $searchValue . '%')->orWhere('user_name', 'like', '%' . $searchValue . '%')->with('roles')->get();

        $response = [
            'status' => 'ok',
            'data' => LawyerResource::collection($lawyers)
        ];

        return response()->json($response, 200);
    }

    public function getUsers()
    {

        $searchValue = request()->query('searchValue');

        $users = User::whereHas('roles', function ($query) {
            $query->where('title', '!=', 'lawyer');
        })->with('roles')->get();

        $response = [
            'status' => 'ok',
            'data' => UserResource::collection($users)
        ];

        return response()->json($response, 200);
    }

    public function banUser(User $user)
    {

        $user->is_banned = 1;
        $user->save();

        $response = [
            'status' => 'ok',
            'message' => 'User has been banned'
        ];

        return response()->json($response, 200);
    }

    public function unbanUser(User $user)
    {

        $user->is_banned = 0;
        $user->save();

        $response = [
            'status' => 'ok',
            'message' => 'User been unbanned'
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
    public function followers(User $user)
    {
        $followers = $user->followers()->with('followers')->get();

        if ($followers->isEmpty()) {
            return response()->json(['status' => 'error', 'message' => 'This user has no followers'], 404);
        }

        $response = [
            'status' => 'ok',
            'followers' => UserPostResource::collection($followers)
        ];

        return response()->json($user, 200);
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
