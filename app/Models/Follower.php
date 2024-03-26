<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    use HasFactory;

    protected $table = 'followers';


    public function users()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'followed_id');
    }
}
