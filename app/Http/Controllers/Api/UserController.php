<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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