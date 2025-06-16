<?php

namespace App\Http\Controllers;

use App\Models\File;
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
        $request->validate([
            'filename' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_public' => 'required|boolean',
            'password_hash' => 'required|string|min:8|regex:/[0-9]/',
            'stored_path' => 'required|file',
        ], [
            'password_hash.regex' => 'The password must contain at least one number.',
            'password_hash.min' => 'The password must be at least 8 characters long.',
            'stored_path.required' => 'The Choose File field is required.',
        ]);
        $uploadedFile = $request->file('stored_path');
        $fileContent = file_get_contents($uploadedFile->getRealPath());
        $password = $request->password_hash;

        // Generate random salt and IV
        $salt = random_bytes(16);
        $ivLength = openssl_cipher_iv_length('aes-256-cbc');
        $iv = random_bytes($ivLength);

        // Derive key from password and salt using PBKDF2 (recommended iterations)
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

        // Use password hash securely for authentication, not encryption key
        $passwordHash = Hash::make($password);

        $filename = $request->input('filename') ?: $uploadedFile->getClientOriginalName();
        File::create([
            'filename' => $filename,
            'description' => $request->description,
            'is_public' => $request->is_public,
            'password_hash' => $passwordHash,
            'owner_id' => auth()->id(),
            'stored_path' => $storedPath,
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
            'stored_path' => 'nullable|file',
        ]);

        // Check if a new file is uploaded
        if ($request->hasFile('stored_path')) {
            // Delete the old file if it exists
            if ($file->stored_path && Storage::exists($file->stored_path)) {
                Storage::delete($file->stored_path);
            }

            // Handle the new file upload
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

            // Store the encrypted file
            $storedPath = 'files/' . $uploadedFile->hashName();
            Storage::put($storedPath, $encryptedData);

            $filename = $request->input('filename') ?: $uploadedFile->getClientOriginalName();
        } else {
            // If no new file is uploaded, keep the existing stored path
            $storedPath = $file->stored_path;
            $filename = $request->input('filename') ?: $file->filename;
        }

        if ($request->filled('password_hash') || $request->filled('old_password_hash')) {
            // Validate the new password if provided

            if (!Hash::check($request->old_password_hash, $file->password_hash)) {
                return back()->withErrors(['password' => 'The provided old password is incorrect.']);
            }
            $request->validate([
                'password_hash' => 'required|string|min:8|regex:/[0-9]/',
            ], [
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
            // If no new password is provided, keep the existing one
            $password_hash = $file->password_hash;
        }

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

        $file->delete();
        return redirect()->route('file.index')->with('success', 'File deleted successfully.');
    }
}


