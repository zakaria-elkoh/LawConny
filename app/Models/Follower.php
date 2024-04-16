<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class Follower extends Model
{
    use HasFactory, Notifiable;



    public function users()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'followed_id');
    }
}
