<?php

use App\Http\Controllers\Api\Admin\PostController;
use App\Http\Controllers\Api\Auth\AuthController;
// use App\Http\Controllers\Api\Lawyer\LikeController;
use App\Http\Controllers\Api\User\PostController as UserPostController;
use App\Http\Controllers\Api\User\CommentController as UserCommentController;
use App\Http\Controllers\Api\User\FollowController as UserFollowController;
use App\Http\Controllers\Api\User\LikeController as UserLikeController;
use App\Http\Controllers\Api\User\SaveController as UserSaveController;
use App\Http\Controllers\Api\User\MessageController as UserMessageController;
use App\Http\Controllers\Api\User\UserController as UserUserController;
use App\Http\Controllers\TweetaController;
use App\Http\Resources\User\UserProfileResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('/chat', [UserMessageController::class, 'message']);



Route::middleware('auth:sanctum')->group(function () {
    Route::get('/posts/search', [UserPostController::class, 'search']);
    Route::get('/users/messages/users', [UserUserController::class, 'getChattingPartners']);
    Route::get('/users/{user}/messages', [UserMessageController::class, 'getMessages']);
    Route::post('/users/message', [UserMessageController::class, 'storeMessage']);
    Route::delete('/users/message', [UserMessageController::class, 'removeMessage']);
    Route::post('/users/{user}/follow', [UserFollowController::class, 'storeFollow']);
    Route::delete('/users/{user}/follow', [UserFollowController::class, 'removeFollow']);
    Route::post('/posts/{post}/like', [UserLikeController::class, 'storeLike']);
    Route::delete('/posts/{post}/like', [UserLikeController::class, 'removeLike']);
    Route::post('/posts/{post}/save', [UserSaveController::class, 'storeSave']);
    Route::delete('/posts/{post}/save', [UserSaveController::class, 'removeSave']);
    Route::apiResource('/comments', UserCommentController::class);
    Route::apiResource('/posts', UserPostController::class);
    // user routes
    Route::get('/users/{user:user_name}', [UserUserController::class, 'showUserByUsername']);
    Route::get('/posts/{user}/saved-posts', [UserUserController::class, 'savedPosts']);
    Route::get('/users/{user}/followers', [UserUserController::class, 'followers']);
    Route::get('/users/{user}/following', [UserUserController::class, 'following']);
    Route::apiResource('/users', UserUserController::class);
});



Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/posts', UserPostController::class)->except(['show']);
});

// Route::get('/posts', [UserPostController::class, 'index']);
Route::get('/posts/{post}', [UserPostController::class, 'show']);


// return the auth user
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    $response = [
        'status' => 'ok',
        'data' => new UserProfileResource($request->user())
    ];

    return response()->json($response, 200);
});



// auth routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum']);
Route::post('/register', [AuthController::class, 'register']);
