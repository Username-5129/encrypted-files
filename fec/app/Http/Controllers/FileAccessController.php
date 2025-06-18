<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\FileAccess;
use App\Models\Logs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FileAccessController extends Controller
{
    private function authorizeUser ($file)
    {
        $user = Auth::user();
        return $user->id === $file->owner_id || $user->isAdmin();
    }

    public function manageAccess(string $id)
    {
        $file = File::findOrFail($id);

        // Check if the user is authorized
        if (!$this->authorizeUser ($file)) {
            return redirect()->back()->with('error', 'You do not have permission to manage access for this file.');
        }

        $user = Auth::user();
        $usersWithAccess = $file->fileAccess()->with('users')->get();
        $friends = $user->friends()->get();
        $friendsWithoutAccess = $friends->filter(function ($friend) use ($file) {
            return !$file->fileAccess()->where('user_id', $friend->id)->exists();
        });

        return view('encrypted_files.manage_access', compact('file', 'usersWithAccess', 'friendsWithoutAccess'));
    }

    public function addAccess($fileId, $userId)
    {
        $file = File::findOrFail($fileId);

        // Check if the user is authorized
        if (!$this->authorizeUser ($file)) {
            return redirect()->back()->with('error', 'You do not have permission to grant access to this file.');
        }

        Logs::create([
            'file_id' => $fileId,
            'user_id' => Auth::user()->id,
            'ip_address' => request()->ip(),
            'action' => 'access add',
        ]);

        FileAccess::create([
            'file_id' => $file->id,
            'user_id' => $userId,
            'can_edit' => false,
        ]);

        return back()->with('success', "Access granted to user.");
    }

    public function toggleEdit($fileId, $userId)
    {
        $fileAccess = FileAccess::where('file_id', $fileId)->where('user_id', $userId)->firstOrFail();
        $file = File::findOrFail($fileId);

        // Check if the user is authorized
        if (!$this->authorizeUser ($file)) {
            return redirect()->back()->with('error', 'You do not have permission to toggle editing for this file.');
        }

        Logs::create([
            'file_id' => $file->id,
            'user_id' => Auth::user()->id,
            'ip_address' => request()->ip(),
            'action' => 'access toggle',
        ]);

        $fileAccess->can_edit = !$fileAccess->can_edit;
        $fileAccess->save();

        return redirect()->back()->with('success', 'Editing permission updated successfully.');
    }

    public function removeAccess($fileId, $userId)
    {
        $fileAccess = FileAccess::where('file_id', $fileId)->where('user_id', $userId)->firstOrFail();
        $file = File::findOrFail($fileId);

        // Check if the user is authorized
        if (!$this->authorizeUser ($file)) {
            return redirect()->back()->with('error', 'You do not have permission to remove access for this file.');
        }

        Logs::create([
            'file_id' => $file->id,
            'user_id' => Auth::user()->id,
            'ip_address' => request()->ip(),
            'action' => 'access remove',
        ]);

        $fileAccess->delete();

        return redirect()->back()->with('success', 'Access removed successfully.');
    }
}
