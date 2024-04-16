<?php

namespace App\Http\Resources\User;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'body' => $this->description,
            'image' => $this->getFirstMediaUrl('post_images_collection'),
            'created_at' => Carbon::parse($this->created_at)->diffForHumans(),
            'author' => new UserPostResource($this->whenLoaded('user')),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'comments_count' => $this->comments->count(),
            'likes_count' => $this->total_likes,
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'is_liked' => $request->user() ? $request->user()->likes->contains($this->id) : false,
            'is_saved' => $request->user() ? $request->user()->saves->contains($this->id) : false,
        ];
    }
}
