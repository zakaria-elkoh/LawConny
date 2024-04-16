<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VerificationRequestUserResource extends JsonResource
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
            'name' => $this->user,
            'user_name' => $this->user_name,
            'email' => $this->email,
            'is_banned' => $this->is_banned,
            'profile_image' => $this->getFirstMediaUrl('profile_images_collection'),
        ];
    }
}
