<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    public function __construct()
    {
    $this->middleware('auth')->except(['encrypted_files.index', 'show']);
    }
}
