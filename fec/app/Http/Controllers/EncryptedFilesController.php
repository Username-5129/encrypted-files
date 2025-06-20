<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\User;
use App\Models\FileAccess;
use App\Models\Logs;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class EncryptedFilesController extends Controller
{
    public function index()
    {
        $files = File::all();

        if (auth()->check()) {
            // Get files that belong to the authenticated user
            $userFiles = $files->filter(function ($file) {
                return $file->owner_id === auth()->id();
            });
            
            $publicFiles = $files->filter(function ($file) {
                return $file->is_public;
            });

            $sharedFiles = $files->filter(function ($file) {
                return auth()->user()->can('viewShared', $file);
            });

            $adminFiles = collect();
            if (Auth::user()->isAdmin()) {
                $adminFiles = $files->filter(function ($file) {
                return !$file->is_public && $file->owner_id !== auth()->id();
            });
                
            }
        } else {
            $publicFiles = $files->filter(function ($file) {
                return $file->is_public;
            });
            
            $userFiles = collect();
            $adminFiles = collect();
            $sharedFiles = collect();
        }

        return view('encrypted_files.index', compact('userFiles', 'publicFiles', 'adminFiles', 'sharedFiles'));
    }

    public function create(Request $request) {

        if (auth()->check()) {
            if ($request->user()->cannot('create', File::class)) {
                abort(403, 'You are not authorized to create a file.');
            }
        } else {
            abort(403, 'You are not authorized to create a file.');
        }
        
        return view('encrypted_files.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'filename' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_public' => 'required|boolean',
            'password_hash' => 'required|string|min:8|regex:/[0-9]/',
            'confirm_password_hash' => 'required|string|same:password_hash',
            'stored_path' => 'required|file',
        ], [
            'password_hash.required' => 'The password field is required.',
            'password_hash.regex' => 'The password must contain at least one number.',
            'password_hash.min' => 'The password must be at least 8 characters long.',
            'confirm_password_hash.same' => 'The confirm password field must match the password field.',

            'stored_path.required' => 'The Choose File field is required.',
        ]);
        $uploadedFile = $request->file('stored_path');
        $fileContent = file_get_contents($uploadedFile->getRealPath());
        $password = $request->password_hash;

        // Generate random salt and IV
        $salt = random_bytes(16);
        $ivLength = openssl_cipher_iv_length('aes-256-cbc');
        $iv = random_bytes($ivLength);

        // Derive key from password and salt using PBKDF2
        $key = hash_pbkdf2('sha256', $password, $salt, 100000, 32, true);

        // Encrypt file content
        $encrypted = openssl_encrypt($fileContent, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
        if ($encrypted === false) {
            return back()->withErrors(['stored_path' => 'File encryption failed.']);
        }

        // Store salt + IV + encrypted data together
        $encryptedData = $salt . $iv . $encrypted;

        // Store encrypted file
        $storedFilename = $uploadedFile->hashName();
        $storedPath = 'files/' . $storedFilename;
        Storage::put($storedPath, $encryptedData);

        // Use password hash securely for authentication
        $password_hash = Hash::make($password);

        $filename = $request->input('filename') ?: $uploadedFile->getClientOriginalName();

        $file = File::create([
            'filename' => $filename,
            'description' => $request->description,
            'is_public' => $request->is_public,
            'password_hash' => $password_hash,
            'owner_id' => auth()->id(),
            'stored_path' => $storedPath,
        ]);

        Logs::create([
            'file_id' => $file->id,
            'user_id' => Auth::user()->id,
            'ip_address' => request()->ip(),
            'action' => 'file create',
        ]);

        return redirect()->route('file.index')->with('success', 'File encrypted and stored successfully.');
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

    public function checkPassword(Request $request, File $file)
    {
        $request->validate([
            'password' => 'required|string',
        ]);
        if (!Hash::check($request->password, $file->password_hash)) {
            return back()->withErrors(['password' => 'The provided password is incorrect.']);
        }

        // User password is correct, prepare to decrypt and download
        $encryptedData = Storage::get($file->stored_path);

        // Extract salt + iv + encrypted content
        $salt = substr($encryptedData, 0, 16);
        $ivLength = openssl_cipher_iv_length('aes-256-cbc');
        $iv = substr($encryptedData, 16, $ivLength);
        $encryptedContent = substr($encryptedData, 16 + $ivLength);

        // Derive key same way as in encryption
        $key = hash_pbkdf2('sha256', $request->password, $salt, 100000, 32, true);

        // Decrypt content
        $decrypted = openssl_decrypt($encryptedContent, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
        if ($decrypted === false) {
            return back()->withErrors(['password' => 'Failed to decrypt file with the given password.']);
        }

        // Create temp file
        $tempFilePath = tempnam(sys_get_temp_dir(), 'decfile_');
        file_put_contents($tempFilePath, $decrypted);

         if (auth()->check()) {
            Logs::create([
            'file_id' => $file->id,
            'user_id' => Auth::user()->id,
            'ip_address' => request()->ip(),
            'action' => 'file download',
        ]);
        } else {
            Logs::create([
            'file_id' => $file->id,
            'user_id' => null,
            'ip_address' => request()->ip(),
            'action' => 'file download',
        ]);
        }



        return response()->download($tempFilePath, $file->filename)->deleteFileAfterSend(true);
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
            'old_password_hash' => 'nullable|string',
            'password_hash' => 'nullable|string',
            'confirm_password_hash' => 'nullable|string|same:password_hash',
            'stored_path' => 'nullable|file',
        ]);

        if ($request->hasFile('stored_path')) {

            $request->validate([
                'password_hash' => 'required|string|min:8|regex:/[0-9]/',
            ], [
                'password_hash.required' => 'The password field is required.',
                'password_hash.regex' => 'The password must contain at least one number.',
                'password_hash.min' => 'The password must be at least 8 characters long.',
            ]);
            if ($file->stored_path && Storage::exists($file->stored_path)) {
                Storage::delete($file->stored_path);
            }
            // return back()->withErrors(['password' => 'file.']);

            $uploadedFile = $request->file('stored_path');
            $fileContent = file_get_contents($uploadedFile->getRealPath());
            $password = $request->password_hash;

            // Generate random salt and IV
            $salt = random_bytes(16);
            $ivLength = openssl_cipher_iv_length('aes-256-cbc');
            $iv = random_bytes($ivLength);

            // Derive key from password and salt using PBKDF2
            $key = hash_pbkdf2('sha256', $password, $salt, 100000, 32, true);

            // Encrypt file content
            $encrypted = openssl_encrypt($fileContent, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
            if ($encrypted === false) {
                return back()->withErrors(['stored_path' => 'File encryption failed.']);
            }

            // Store salt + IV + encrypted data together
            $encryptedData = $salt . $iv . $encrypted;

            // Store encrypted file
            $storedFilename = $uploadedFile->hashName();
            $storedPath = 'files/' . $storedFilename;
            Storage::put($storedPath, $encryptedData);

            // Use password hash securely for authentication
            $password_hash = Hash::make($password);

            $filename = $request->input('filename') ?: $uploadedFile->getClientOriginalName();

        } else if ($request->filled('password_hash') || $request->filled('old_password_hash')) {
            $storedPath = $file->stored_path;
            $filename = $request->input('filename') ?: $file->filename;
            if (!$request->filled('old_password_hash')) {
                return back()->withErrors(['password' => 'The old password must be provided.']);
            }
            if (!Hash::check($request->old_password_hash, $file->password_hash)) {
                return back()->withErrors(['password' => 'The provided old password is incorrect.']);
            }
            $request->validate([
                'password_hash' => 'required|string|min:8|regex:/[0-9]/',
            ], [
                'password_hash.required' => 'The password field is required.',
                'password_hash.regex' => 'The new password must contain at least one number.',
                'password_hash.min' => 'The new password must be at least 8 characters long.',
            ]);
            $password_hash = Hash::make($request->password_hash);

            // Decrypt the existing file content
            $encryptedData = Storage::get($file->stored_path);
            $salt = substr($encryptedData, 0, 16);
            $ivLength = openssl_cipher_iv_length('aes-256-cbc');
            $iv = substr($encryptedData, 16, $ivLength);
            $encryptedContent = substr($encryptedData, 16 + $ivLength);

            // Derive key from the old password and salt
            $oldKey = hash_pbkdf2('sha256', $request->old_password_hash, $salt, 100000, 32, true);
            // Decrypt the file content
            $decryptedContent = openssl_decrypt($encryptedContent, 'aes-256-cbc', $oldKey, OPENSSL_RAW_DATA, $iv);
            if ($decryptedContent === false) {
                return back()->withErrors(['stored_path' => 'Failed to decrypt file with the given password.']);
            }
            
            // Re-encrypt the file content with the new password hash
            $newSalt = random_bytes(16);
            $newIv = random_bytes(openssl_cipher_iv_length('aes-256-cbc'));
            $newKey = hash_pbkdf2('sha256', $request->password_hash, $newSalt, 100000, 32, true);
            $newEncrypted = openssl_encrypt($decryptedContent, 'aes-256-cbc', $newKey, OPENSSL_RAW_DATA, $newIv);
            if ($newEncrypted === false) {
                return back()->withErrors(['stored_path' => 'File re-encryption failed.']);
            }
            // Store new salt + IV + re-encrypted data together
            $encryptedData = $newSalt . $newIv . $newEncrypted;
            Storage::put($storedPath, $encryptedData);
        } else {
            $filename = $request->input('filename') ?: $file->filename;
            $password_hash = $file->password_hash;
            $storedPath = $file->stored_path;
        }

        Logs::create([
            'file_id' => $file->id,
            'user_id' => Auth::user()->id,
            'ip_address' => request()->ip(),
            'action' => 'file update',
        ]);

        // Update the file record
        $file->update([
            'filename' => $filename,
            'description' => $request->description,
            'is_public' => $request->is_public,
            'password_hash' => $password_hash,
            'stored_path' => $storedPath,
        ]);

        return view('encrypted_files.show', compact('file'));
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

        Logs::create([
            'file_id' => $file->id,
            'user_id' => Auth::user()->id,
            'ip_address' => request()->ip(),
            'action' => 'file delete',
        ]);
        
        $file->delete();

        return redirect()->route('file.index')->with('success', 'File deleted successfully.');
    }
}


