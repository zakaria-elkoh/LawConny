<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(StoreUserRequest $request)
    {

        $user = User::create([
            'name' => $request->name,
            'user_name' => $request->user_name,
            'password' => Hash::make($request->password)
        ]);


        if (!$user) {
            $response = [
                'message' => 'can not create this user'
            ];
            return response()->json($response, 201);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response()->json($response, 201);
    }

    public function login(LoginRequest $request)
    {

        $user = User::where('user_name', $request->user_name_email)->orwhere('email', $request->user_name_email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            $response = [
                'message' => 'User name or password is incorect'
            ];

            return response()->json($response, 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'message' => 'User successfully login',
            'token' => $token,
            'user' => $user,
        ];

        return response()->json($response, 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}
