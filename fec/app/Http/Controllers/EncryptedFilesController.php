<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;

class EncryptedFilesController extends Controller
{
    public function index()
    {
        $files = File::all();
        return view('encrypted_files.index', compact('files'));
    }

    public function show(string $id)
    {
        $file = File::findOrFail($id);
        return view('encrypted_files.show', compact('file'));
    }

}
