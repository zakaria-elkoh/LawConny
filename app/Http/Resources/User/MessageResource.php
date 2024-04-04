<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $createdAt = $this->created_at;
        // $formattedCreatedAt = '';

        if ($createdAt->diffInDays() < 1) {
            $formattedCreatedAt = $createdAt->format('H:i');
            // $formattedCreatedAt = $createdAt->diffForHumans();
        } else {
            $formattedCreatedAt = $createdAt->format('j F');
        }

        return [
            'message' => $this->message,
            'sender_id' => $this->sender_id,
            'receiver_id' => $this->receiver_id,
            'created_at' => $formattedCreatedAt
        ];
    }
}
