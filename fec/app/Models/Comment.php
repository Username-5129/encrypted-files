<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
  protected $fillable = [
        'file_id',
        'user_id',
        'content',
    ];

    public function files()
    {
        return $this->belongsTo(File::class, 'file_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
