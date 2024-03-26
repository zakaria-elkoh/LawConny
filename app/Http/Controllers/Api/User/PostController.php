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
    *    path="/api/students",
    *    tags={"Students"},
    *    summary="Get all students",
    *    description="Retrieve a list of all students",
    * @OA\Response(response="200", description="List of students"),
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
    *    path="/api/students",
        *       tags={"Students"},
        *       summary="Create a new student",
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

        $response = [
            'message' => 'Post created with success',
            'data' => $post,
        ];

        return response()->json($response, 201);
    }

    
    
    /** @OA\Get(
    *       path="/api/students/{id}",
    *       tags={"Students"},
    *       summary="Get a student by ID",
    *       description="Retrieve a student by its ID",
    *    @OA\Parameter(
    *       name="id",
    *       in="path",
    *       required=true,
    *       description="ID of the student to retrieve",
    *    @OA\Schema(type="integer")
    *    ),
    *    @OA\Response(response="200", description="Student found"),
    *    @OA\Response(response="404", description="Student not found")
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
    *          path="/api/students/{id}",
    *          tags={"Students"},
    *          summary="Update a student",
    *          description="Update the details of a student",
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
    *      @OA\Response(response="200", description="Student updated"),
    *      @OA\Response(response="400", description="Bad request"),
    *      @OA\Response(response="404", description="Student not found")
    *   )
    */
    public function update(UpdatePostRequest $request, Post $post)
    {
        //
    }

    
    /**
 
    *   @OA\Delete(
    *         path="/api/students/{id}",
    *         tags={"Students"},
    *         summary="Delete a student",
    *         description="Delete a student by its ID",
    *      @OA\Parameter(
    *          name="id",
    *          in="path",
    *          required=true,
    *          description="ID of the student to delete",
    *      @OA\Schema(type="integer")
    *      ),
    *      @OA\Response(response="204", description="Student deleted"),
    *      @OA\Response(response="404", description="Student not found")
    *   )
    */
    public function destroy(Post $post)
    {
        return "you wanna delete a post";
    }
}
