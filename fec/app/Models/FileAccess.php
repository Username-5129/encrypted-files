<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileAccess extends Model
{
    protected $fillable = [
        'file_id',
        'user_id',
        'can_edit',
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
