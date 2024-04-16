<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\VerificationRequestResource;
use App\Models\User;
use App\Models\VerificationRequest;
use Illuminate\Http\Request;

class VerificationRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requests = VerificationRequest::where('status', 'pending')->with('user')->paginate(5);

        return response()->json(VerificationRequestResource::collection($requests), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function acceptRequest(Request $request)
    {
        $request = VerificationRequest::findOrFail($request->query('request_id'));
        $user = User::findOrFail($request->user_id);
        $user->is_verified = 1;
        $user->save();
        $request->update([
            'status' => 'accepted'
        ]);

        return response()->json("request accepted with success", 200);
    }

    public function rejectRequest(Request $request)
    {
        $request = VerificationRequest::findOrFail($request->query('request_id'));
        $request->update([
            'status' => 'rejected'
        ]);

        return response()->json("request rejected with success", 200);
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
