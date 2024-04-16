<?php

namespace App\Http\Resources\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LawyerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'lawyer' => 'lawyer resource',
            'id' => $this->id,
            'user_name' => $this->user_name,
            'name' => $this->name,
            'email' => $this->email,
            'joined_at' => Carbon::parse($this->created_at)->format('d M Y'),
            'profile_image' => $this->getFirstMediaUrl('profile_images_collection'),
            'roles' => $this->roles->pluck('title'),
            'is_verified' => $this->is_verified ? true : false,
            'is_banned' => $this->is_banned ? true : false,
            'is_followed' => $request->user() ? $request->user()->following->contains($this->id) : false,
        ];
    }
}
