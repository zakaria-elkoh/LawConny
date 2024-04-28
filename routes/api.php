<?php

use App\Http\Controllers\Api\Admin\PostController;
use App\Http\Controllers\Api\Admin\StatisticController as AdminStatisticController;
use App\Http\Controllers\Api\Admin\UserController as AdminUserController;
use App\Http\Controllers\Api\Admin\VerificationRequestController as AdminVerificationRequestController;
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
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\PostController as ControllersPostController;
use App\Http\Resources\User\UserProfileResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('/chat', [UserMessageController::class, 'message']);

Route::get('/admin/test', function () {
    return response()->json('hello admin');
})->middleware(['auth:sanctum', 'isAdmin']);





Route::middleware('auth:sanctum')->group(function () {
    // admin routes
    Route::middleware('isAdmin')->group(function () {
        Route::apiResource('/admin/statistic', AdminStatisticController::class);
        Route::get('/admin/lawyers', [AdminUserController::class, 'getLawyers']);
        Route::get('/admin/verification/requests/accept', [AdminVerificationRequestController::class, 'acceptRequest']);
        Route::get('/admin/verification/requests/reject', [AdminVerificationRequestController::class, 'rejectRequest']);
        Route::get('/admin/verification/requests', [AdminVerificationRequestController::class, 'index']);
        Route::get('/admin/lawyers/search', [AdminUserController::class, 'searchLawyers']);
        Route::get('/admin/users', [AdminUserController::class, 'getUsers']);
        Route::get('/admin/users/search', [AdminUserController::class, 'searchUsers']);
        Route::get('/admin/users/{user}/ban/', [AdminUserController::class, 'banUser']);
        Route::get('/admin/users/{user}/unban/', [AdminUserController::class, 'unbanUser']);
        Route::get('/admin/posts', [AdminUserController::class, 'getPosts']);
        Route::delete('/admin/posts/{post}', [AdminUserController::class, 'deletePost']);
    });

    // public routes
    Route::put('/profile/updated/{user}', [UserController::class, 'updateProfile']);
    Route::get('/users/all', [UserController::class, 'index']);
    Route::get('/user-by-id/{user}', [UserController::class, 'getUserById']);
    Route::apiResource('/users', UserUserController::class);
    Route::get('/users/all/search', [UserController::class, 'search']);
    Route::get('/user', [UserController::class, 'getAuthUser']);
    Route::post('/profile/update/profile-image', [UserController::class, 'updateProfileImage']);
    Route::get('/profile/verify', [UserController::class, 'getVerificationRequestStatu']);
    Route::post('/profile/verify/request', [UserController::class, 'storeVerificationRequest']);
    Route::get('/myFollowing', [UserController::class, 'getMyFollowing']);
    Route::get('/myFollowers', [UserController::class, 'getMyFollowers']);
    Route::get('/{user}/following', [UserController::class, 'following']);
    Route::get('/{user}/followers', [UserController::class, 'followers']);
    Route::get('/user-posts/{user}', [UserController::class, 'getPostsByUser']);
    Route::get('/posts/favorites', [UserController::class, 'getFavePosts']);
    Route::get('/posts/saves', [UserController::class, 'getSavedPosts']);

    // user routes
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
    Route::get('/users/{id}/followers', [UserUserController::class, 'followers']);
    Route::get('/users/{user}/following', [UserUserController::class, 'following']);
});



Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/posts', UserPostController::class)->except(['show']);
});

// Route::get('/posts', [UserPostController::class, 'index']);
Route::get('/posts/{post}', [UserPostController::class, 'show']);


// return the auth user
Route::middleware('auth:sanctum')->get('/auth-user', function (Request $request) {
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
