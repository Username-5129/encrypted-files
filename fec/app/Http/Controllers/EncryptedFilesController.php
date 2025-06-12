<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EncryptedFilesController extends Controller
{
    public function index()
    {
        $files = File::all();
        return view('encrypted_files.index', compact('files'));
    }

    public function create(Request $request) {
        if ($request->user()->cannot('create', File::class)) {
            abort(403, 'You are not authorized to create a job file.');
        }
        
        return view('encrypted_files.create');
    }

    public function store(Request $request) {
        if ($request->user()->cannot('create', File::class)) {
            abort(403, 'You are not authorized to create a job file.');
        }

        $request->validate([
            'filename' => 'required|string|max:255',
            'description' => 'required|string',
            'is_public' => 'required|boolean',
            'stored_path' =>'required|file',
            'password_hash' => 'required|string|max:255',
        ]);

        $request->stored_path = $request->file('stored_path')->store('stored_path');

        File::create([
            'filename' => $request->filename,
            'stored_path' =>$request->stored_path,
            'description' => $request->description,
            'is_public' => (bool)$request->is_public,
            'owner_id' => Auth::id(),
            'password_hash' => $request->password_hash,
        ]);

        return redirect()->route('files.index')->with('success', 'File created successfully!');
    }


    public function show(string $id)
    {
        $file = File::findOrFail($id);
        return view('encrypted_files.show', compact('file'));
    }

}
