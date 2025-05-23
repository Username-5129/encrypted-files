<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EncryptedFilesController extends Controller
{
    public function index()
    {
        return view('encrypted_files/index');
    }
}
