<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\User\PostResource;
use Illuminate\Http\Request;

// use GuzzleHttp\Psr7\Request;

class PostController extends Controller
{

    /**
     * @OA\Get(
     *    path="/api/posts",
     *    tags={"posts"},
     *    summary="Get all posts",
     *    description="Retrieve a list of all posts",
     * @OA\Response(response="200", description="List of posts"),
     * @OA\Response(response="404", description="No student found"),
     * )
     */
    public function index()
    {
        $posts = Post::with('user', 'tags')->orderBy('created_at', 'DESC')->paginate(5);

        $response = [
            'status' => 'ok',
            'data' => PostResource::collection($posts)
        ];

        return response()->json($response, 200);
    }

    /**
     * return the comments of an post.
     */
    // public function postComments(Post $post)
    // {
    //     $comments = $post->comments;
    //     return response()->json($comments);
    // }


    /** @OA\Post(
     *    path="/api/posts",
     *       tags={"posts"},
     *       summary="Create a new post",
     *       description="Create a new student with provided name and age",
     *    @OA\RequestBody(
     *       required=true,
     *    @OA\JsonContent(
     *       required={"name", "age"},
     *    @OA\Property(property="name", type="string"),
     *    @OA\Property(property="age", type="integer")
     *    )
     *    ),
     *    @OA\Response(response="201", description="Student created"),
     *    @OA\Response(response="400", description="Bad request")
     *    )
     */
    public function store(StorePostRequest $request)
    {
        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => $request->user()->id,
        ]);

        $post->addMediaFromRequest('post_image')->toMediaCollection('post_images_collection');

        $response = [
            'message' => 'Post created with success',
            'data' => $post,
        ];

        return response()->json($response, 201);
    }



    /** @OA\Get(
     *       path="/api/posts/{id}",
     *       tags={"posts"},
     *       summary="Get a post by ID",
     *       description="Retrieve a post by its ID",
     *    @OA\Parameter(
     *       name="id",
     *       in="path",
     *       required=true,
     *       description="ID of the post to retrieve",
     *    @OA\Schema(type="integer")
     *    ),
     *    @OA\Response(response="200", description="post found"),
     *    @OA\Response(response="404", description="post not found")
     *    )
     */

    public function show(Post $post)
    {
        $post->load('comments', 'tags', 'user');

        $response = [
            'status' => 'ok',
            'data' => new PostResource($post)
        ];

        return response()->json($response, 200);
    }


    /**
 
     *   @OA\Put(
     *          path="/api/posts/{id}",
     *          tags={"posts"},
     *          summary="Update a student",
     *          description="Update the details of a post",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID of the student to update",
     *      @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *      @OA\JsonContent(
     *          required={"name", "age"},
     *      @OA\Property(property="name", type="string"),
     *      @OA\Property(property="age", type="integer")
     *      )
     *      ),
     *      @OA\Response(response="200", description="post updated"),
     *      @OA\Response(response="400", description="Bad request"),
     *      @OA\Response(response="404", description="post not found")
     *   )
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        //
    }


    /**
 
     *   @OA\Delete(
     *         path="/api/posts/{id}",
     *         tags={"posts"},
     *         summary="Delete a post",
     *         description="Delete a post by its ID",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID of the post to delete",
     *      @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(response="204", description="post deleted"),
     *      @OA\Response(response="404", description="post not found")
     *   )
     */
    public function destroy(Post $post)
    {
        return "you wanna delete a post";
    }
}
