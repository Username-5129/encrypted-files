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

    // public function __construct()
    // {
    //     $this->middleware('auth')->except(['encrypted_files.index', 'show']);
    // }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
