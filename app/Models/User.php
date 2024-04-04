<?php

namespace App\Models;


// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, InteractsWithMedia;

    public function getRouteKeyName()
    {
        return 'user_name';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'user_name',
        'email',
        'password',
        'profile_image'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function saves()
    {
        return $this->belongsToMany(Post::class, 'saves', 'user_id', 'post_id');
    }

    public function sentMessages()
    {
        return $this->belongsToMany(User::class, 'message_user', 'sender_id', 'receiver_id')
            ->withPivot(['message']);
    }

    public function receivedMessages()
    {
        return $this->belongsToMany(User::class, 'message_user', 'receiver_id', 'sender_id')
            ->withPivot(['message']);
    }

    public function likes()
    {
        return $this->belongsToMany(Post::class, 'likes');
    }

    // works
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'followed_id', 'follower_id');
    }
    
    // works
    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'followed_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'comments');
    }

    public function notifications()
    {
        // return $this->hasMany(Notification::class);
    }
}
