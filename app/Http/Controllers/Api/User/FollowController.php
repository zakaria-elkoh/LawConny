<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Follower;
use App\Http\Requests\StoreFollowerRequest;
use App\Http\Requests\UpdateFollowerRequest;
use App\Models\User;
use App\Notifications\FollowNotification;
use Illuminate\Http\Request;

class FollowController extends Controller
{

    // public function getFollowing(Request $request)
    // {

    //     $followings = $request->user()->following()->paginate(5);

    //     return response()->json($followings, 200);
    // }

    // public function getFollowing(Request $request)
    // {

    //     $followings = $request->user()->following()->paginate(5);

    //     return response()->json($followings, 200);
    // }

    public function storeFollow(Request $request, User $user)
    {

        // $follower = $request->user();
        $request->user()->following()->sync($user->id);

        // $user->notify(new FollowNotification($follower));

        return response()->json($request->user() . ' lllsl ' . $user, 201);
    }

    public function removeFollow(Request $request, User $user)
    {

        $request->user()->following()->detach($user->id);

        return response()->json("removed the follow" . $user, 201);
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }


    public function store(StoreFollowerRequest $request)
    {
        //
    }


    public function show(Follower $follower)
    {
        //
    }


    public function edit(Follower $follower)
    {
        //
    }

    public function update(UpdateFollowerRequest $request, Follower $follower)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Follower $follower)
    {
        //
    }
}
