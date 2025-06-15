<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function files() {
        return $this->hasMany(File::class, 'owner_id');
    }
    public function comments() {
        return $this->hasMany(Comment::class);
    }
    public function friends() {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id');
    }
    public function friendRequestsSent() {
        return $this->hasMany(FriendRequest::class, 'sender_id');
    }
    public function friendRequestsReceived() {
        return $this->hasMany(FriendRequest::class, 'receiver_id');
    }

    public function isAdmin() {
        return $this->role === 'admin';
    }
    public function isUser() {
        return $this->role === 'user';
    }
}
