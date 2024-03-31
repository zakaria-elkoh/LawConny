<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Follower;
use App\Http\Requests\StoreFollowerRequest;
use App\Http\Requests\UpdateFollowerRequest;

class FollowerController extends Controller
{
   
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
