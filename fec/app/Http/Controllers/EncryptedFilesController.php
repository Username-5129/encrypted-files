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

        if (auth()->check()) {
            $files = $files->filter(function ($file) {
                return auth()->user()->can('view', $file);
            });
        } else {
            $files = $files->filter(function ($file) {
                return $file->is_public;
            });
        }

        // Return the view with the filtered files
        return view('encrypted_files.index', compact('files'));
    }


    public function create(Request $request) {
        if ($request->user()->cannot('create', File::class)) {
            abort(403, 'You are not authorized to create a file.');
        }
        
        return view('encrypted_files.create');
    }

    public function store(Request $request) {
        if ($request->user()->cannot('create', File::class)) {
            abort(403, 'You are not authorized to create a file.');
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

        if (auth()->check()) {
            if (auth()->user()->cannot('view', $file)) {
                abort(403, 'Unauthorized to view this file.');
            }
        } else {
            if (!$file->is_public) {
                abort(403, 'Unauthorized to view this file.');
            }
        }

        return view('encrypted_files.show', compact('file'));
    }


    public function download(File $file)
    {
        if (auth()->check()) {
            if (auth()->user()->cannot('view', $file)) {
                abort(403, 'Unauthorized to download this file.');
            }
        } else {
            if (!$file->is_public) {
                abort(403, 'Unauthorized to download this file.');
            }
        }

        if (!Storage::exists($file->stored_path)) {
            abort(404, 'File not found.');
        }

        return Storage::download($file->stored_path, $file->filename);
    }

}
