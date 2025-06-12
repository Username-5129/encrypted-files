<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = [
        'name',
        'code',
    ];

    public function user()
    {
        return $this->hasMany(User::class, 'language_id');
    }
}

