<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\File;
use App\Models\Logs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, $fileId)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        Logs::create([
            'file_id' => $fileId,
            'user_id' => Auth::user()->id,
            'ip_address' => request()->ip(),
            'action' => 'comment add',
        ]);

        $comment = new Comment();
        $comment->file_id = $fileId;
        $comment->user_id = Auth::id();
        $comment->content = $request->content;
        $comment->save();

        return redirect()->route('file.show', $fileId)->with('success', 'Comment added successfully.');
    }

    public function edit(Comment $comment)
    {
        $this->authorize('update', $comment);

        return view('comments.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        Logs::create([
            'file_id' => $comment->file_id,
            'user_id' => Auth::user()->id,
            'ip_address' => request()->ip(),
            'action' => 'comment edit',
        ]);

        $comment->content = $request->content;
        $comment->save();

        return redirect()->route('file.show', $comment->file_id)->with('success', 'Comment updated successfully.');
    }



    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        Logs::create([
            'file_id' => $comment->file_id,
            'user_id' => Auth::user()->id,
            'ip_address' => request()->ip(),
            'action' => 'comment delete',
        ]);

        $comment->delete();
        return back()->with('success', 'Comment deleted successfully.');
    }
}