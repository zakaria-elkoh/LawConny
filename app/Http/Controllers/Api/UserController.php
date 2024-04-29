<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\PostResource;
use App\Http\Resources\User\UserPostResource;
use App\Http\Resources\User\UserProfileResource;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Models\VerificationRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $users = [];


        if ($request->user()->id) {
            // $users = User::orderBy('id', 'desc')->paginate(9);
            $users = User::whereNotIn('id', auth()->user()->following()->pluck('id'))
                ->where('id', '!=', auth()->user()->id)
                ->where('is_banned', 0)
                ->orderBy('id', 'desc')
                ->paginate(9);
        } else {
            $users = User::orderBy('id', 'desc')->paginate(9);
        }


        $response = [
            'status' => 'ok',
            'data' => UserResource::collection($users)
        ];

        return response()->json($response, 200);
    }

    public function getFavePosts(Request $request)
    {
        $posts = $request->user()->favePosts()->with('user')->paginate(9);

        $response = [
            'status' => 'ok',
            'faves' => 'favorite posts',
            'data' => PostResource::collection($posts)
        ];

        return response()->json($response, 200);
    }

    public function getSavedPosts(Request $request)
    {
        $posts = $request->user()->savedPosts()->with('user')->paginate(9);

        $response = [
            'status' => 'ok',
            'saves' => 'saved posts',
            'data' => PostResource::collection($posts)
        ];

        return response()->json($response, 200);
    }

    public function getUserById(Request $request, User $user)
    {
        $response = [
            'status' => 'ok',
            'data' => new UserResource($user)
        ];

        return response()->json($response, 200);
    }

    public function updateProfile(Request $request, User $user)
    {
        if ($request->name !== $user->name) {
            $user->update([
                'is_verified' => 0
            ]);
        }

        $newUser = $user->update([
            // 'user_name' => $request->user_name,
            'name' => $request->name,
            'email' => $request->email,
            'bio' => $request->bio,
        ]);


        return response()->json($newUser, 200);
    }

    public function getPostsByUser(Request $request, User $user)
    {

        $posts = $user->posts()->with('user')->paginate(9);

        $response = [
            'status' => 'ok',
            'data' => PostResource::collection($posts)
        ];

        return response()->json($response, 200);
    }

    public function following(Request $request, User $user)
    {

        $following = $user->following()->get();

        $response = [
            'status' => 'ok',
            'data' => UserResource::collection($following)
        ];

        return response()->json($response, 200);
    }

    public function followers(Request $request, User $user)
    {

        $followers = $user->followers()->get();

        $response = [
            'status' => 'ok',
            'data' => UserResource::collection($followers)
        ];

        return response()->json($response, 200);
    }

    public function search(Request $request)
    {
        $searchValue = $request->query('searchValue');
        $usersType = $request->query('usersType');

        $usres = [];

        if ($usersType == 'all') {
            $usres = User::where('name', 'like', '%' . $searchValue . '%')
                ->orderBy('created_at', 'DESC')
                ->paginate();
        } elseif ($usersType == 'lawyer') {
            $usres = User::whereHas('roles', function ($query) {
                $query->where('title', 'lawyer');
            })->where('name', 'like', '%' . $searchValue . '%')
                ->orderBy('created_at', 'DESC')
                ->paginate();
        } else {
            $usres = User::whereHas('roles', function ($query) {
                $query->where('title', 'user');
            })->where('name', 'like', '%' . $searchValue . '%')
                ->orderBy('created_at', 'DESC')
                ->paginate();
        }

        $response = [
            'status' => 'ok',
            'data' => UserResource::collection($usres)
        ];

        return response()->json($response, 200);
    }

    public function updateProfileImage(Request $request)
    {

        $user = $request->user();

        $oldProfileImage = $user->getFirstMedia('profile_images_collection');

        // Delete the existing profile image if it exists
        if ($oldProfileImage) {
            $oldProfileImage->delete();
        }


        if ($request->hasFile('profile_image')) {
            $user->addMediaFromRequest('profile_image')->toMediaCollection('profile_images_collection');
        }

        // Upload the new profile image to the media library
        // $profileImage = $request->file('profile_image');
        // if ($profileImage) {
        //     $user->addMedia($profileImage)->toMediaCollection('profile_image');
        // }

        $response = [
            'status' => 'ok',
        ];

        return response()->json($response, 200);
    }

    public function getAuthUser(Request $request)
    {
        $response = [
            'status' => 'ok',
            'auth' => 'auth user',
            'data' => new UserProfileResource($request->user())
        ];

        return response()->json($response, 200);
    }

    public function storeVerificationRequest(Request $request)
    {

        $response = [
            'status' => 'ok',
            'data' => $request->message,
            'message' => 'Verification request sent successfully'
        ];

        VerificationRequest::create([
            'status' => 'pending',
            'description' => $request->message,
            'user_id' => $request->user()->id
        ]);

        $request->user()->is_verified = 2;
        $request->user()->save();

        return response()->json($response, 200);
    }

    /**
     * get the followers
     */
    public function getMyfollowers(Request $request)
    {
        $followers = $request->user()->followers()->with('followers')->get();

        $response = [
            'status' => 'ok',
            'data' => UserResource::collection($followers)
        ];

        return response()->json($response, 200);
    }
    /**
     * get who I am following
     */
    public function getMyfollowing(Request $request)
    {
        $following = $request->user()->following()->get();

        $response = [
            'status' => 'ok',
            'data' => UserResource::collection($following)
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
