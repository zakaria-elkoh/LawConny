<?php

namespace App\Http\Resources\User;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'user_name' => $this->user_name,
            'name' => $this->name,
            'joined_at' => Carbon::parse($this->created_at)->format('d M Y'),
            'profile_image' => $this->getFirstMediaUrl('profile_images_collection'),
            'roles' => $this->roles->pluck('title'),
            'is_banned' => $this->is_banned ? true : false,
            'bio' => $this->bio,
            'email' => $this->email,
            'is_verified' => $this->is_verified == 1 ? true : false,
            'is_followed' => $request->user() ? $request->user()->following->contains($this->id) : false,
            'followers_count' => $this->followers->count(),
            'following_count' => $this->following->count(),
            'posts_count' => $this->posts->count(),
        ];
    }
}
