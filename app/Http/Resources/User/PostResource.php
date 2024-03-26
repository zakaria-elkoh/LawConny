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
            'title' => $this->title,
            'body' => $this->description,
            'created_at' => Carbon::parse($this->created_at)->diffForHumans(),
            'author' => new UserPostResource($this->whenLoaded('user')),
            // 'updated_at' => Carbon::parse($this->updated_at)->diffForHumans(),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'comments_count' => $this->comments->count(),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
        ];
    }
}
