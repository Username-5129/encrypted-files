<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'filename',
        'stored_path',
        'description',
        'owner_id',
        'is_public',
        'password_hash',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'file_id');
    }

    public function logs()
    {
        return $this->hasMany(Logs::class, 'file_id');
    }

    public function fileAccess()
    {
        return $this->hasMany(FileAccess::class, 'file_id');
    }
}
