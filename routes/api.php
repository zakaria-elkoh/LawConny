<?php

use App\Http\Controllers\Api\Admin\PostController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\User\PostController as UserPostController;
use App\Http\Controllers\Api\User\CommentController as UserCommentController;
use App\Http\Controllers\Api\User\UserController as UserUserController;
use App\Http\Controllers\TweetaController;
use App\Http\Resources\User\UserProfileResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::apiResource('/tweetas', TweetaController::class);

// auth routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum']);
Route::post('/register', [AuthController::class, 'register']);

// post routes
// Route::apiResource('/posts', PostController::class);

// Route::get('/posts/{post}/comments', [UserPostController::class, 'postComments']);
Route::apiResource('/comments', UserCommentController::class);



Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/posts', UserPostController::class);
    // user routes
    Route::get('/posts/{user}/saved-posts', [UserUserController::class, 'savedPosts']);
    Route::get('/users/{user}/followers', [UserUserController::class, 'followers']);
    Route::get('/users/{user}/following', [UserUserController::class, 'following']);
    Route::apiResource('/users', UserUserController::class);
});

Route::get('/posts', [UserPostController::class, 'index']);
Route::get('/posts/{post}', [UserPostController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/posts', UserPostController::class)->except(['index', 'show']);
});


// return the auth user
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    $response = [
        'status' => 'ok',
        'data' => new UserProfileResource($request->user())
    ];

    return response()->json($response, 200);
});
