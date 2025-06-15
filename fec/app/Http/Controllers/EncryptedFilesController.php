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

    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'filename' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_public' => 'required|boolean',
            'password_hash' => 'required|string|min:8|regex:/[0-9]/',
            'stored_path' => 'required|file',
        ], [
            'password_hash.regex' => 'The password must contain at least one number.',
            'password_hash.min' => 'The password must be at least 8 characters long.',
        ]);

        // Handle the file upload
        $uploadedFile = $request->file('stored_path');
        $storedPath = $uploadedFile->store('files');

        $filename = $request->input('filename');
        if (empty($filename)) {
            $filename = $uploadedFile->getClientOriginalName();
        }

        File::create([
            'filename' => $filename,
            'description' => $request->description,
            'is_public' => $request->is_public,
            'password_hash' => $request->password_hash,
            'owner_id' => Auth::id(),
            'stored_path' => $storedPath,
        ]);

        return redirect()->route('file.index')->with('success', 'File created successfully.');
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

    public function edit(Request $request, string $id)
    {
        $file = File::findOrFail($id);

        $this->authorize('update', $file);

        return view('encrypted_files.edit', compact('file'));

    }

    public function update(Request $request, string $id)
    {
        $file = File::findOrFail($id);

        $this->authorize('update', $file);

        $request->validate([
            'filename' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_public' => 'required|boolean',
            'password_hash' => 'required|string|min:8|regex:/[0-9]/',
        ], [
            'password_hash.regex' => 'The password must contain at least one number.',
            'password_hash.min' => 'The password must be at least 8 characters long.',
        ]);

        if ($file->stored_path && Storage::exists($file->stored_path)) {
            Storage::delete($file->stored_path);
        }

        $uploadedFile = $request->file('stored_path');
        $storedPath = $uploadedFile->store('files');

        $filename = $request->input('filename');
        if (empty($filename)) {
            $filename = $uploadedFile->getClientOriginalName();
        }

        $file->update([
            'filename' => $filename,
            'description' => $request->description,
            'is_public' => $request->is_public,
            'password_hash' => $request->password_hash,
            'stored_path' => $storedPath,
        ]);

        return redirect()->route('file.index')->with('success', 'File updated successfully.');
    }

    public function destroy(Request $request, string $id)
    {
        $file = File::findOrFail($id);

        if ($request->user()->cannot('delete', $file)) {
            abort(403, 'You are not authorized to delete this file.');
        }

        if ($file->stored_path && Storage::exists($file->stored_path)) {
            Storage::delete($file->stored_path);
        }

        $file->delete();
        return redirect()->route('file.index')->with('success', 'File deleted successfully.');
    }
}


