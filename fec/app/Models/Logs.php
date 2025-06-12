<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
     protected $fillable = [
        'file_id',
        'user_id',
        'ip_address',
        'action',
    ];

    public function files()
    {
        return $this->belongsTo(Files::class, 'file_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
