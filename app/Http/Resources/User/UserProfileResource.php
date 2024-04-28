<?php

namespace App\Http\Resources\User;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
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
            'cover_image' => $this->cover_image,
            'bio' => $this->bio,
            'location' => $this->location,
            'is_verified' => $this->is_verified === 2 ? 'pending' : ($this->is_verified ? true : false),
            // 'website' => $this->website,
            'roles' => $this->roles->pluck('title'),
            'email' => $this->email,
            'followers_count' => $this->followers->count(),
            'following_count' => $this->following->count(),
            'posts_count' => $this->posts->count(),
        ];
    }
}
