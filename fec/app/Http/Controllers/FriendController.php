<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Friend;
use App\Models\FriendRequest;
use Auth;

class FriendController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $friends = $user->friends()->get();
        $friendRequests = $user->friendRequestsReceived()->where('status', 'pending')->with('sender')->get();

        return view('friends.index', compact('friends', 'friendRequests'));
    }




    public function add(Request $request)
    {
        $request->validate([
            'friend_email' => 'required|email',
        ]);

        $user = Auth::user();
        $receiver = User::where('email', $request->friend_email)->first();

        if (!$receiver) {
            return back()->with('error', "No user found with the email {$request->friend_email}.");
        }

        if ($receiver->id === $user->id) {
            return back()->with('error', "You cannot send a friend request to yourself.");
        }

        // Check if an existing friendship exists
        $alreadyFriends = Friend::where(function($q) use ($user, $receiver) {
            $q->where('user_id', $user->id)->where('friend_id', $receiver->id);
        })->orWhere(function($q) use ($user, $receiver) {
            $q->where('user_id', $receiver->id)->where('friend_id', $user->id);
        })->exists();

        if ($alreadyFriends) {
            return back()->with('error', "You are already friends with {$receiver->email}.");
        }

        // Check if a friend request already exists (sent or received)
        $existingRequest = FriendRequest::where(function($q) use ($user, $receiver) {
            $q->where('sender_id', $user->id)->where('receiver_id', $receiver->id);
        })->orWhere(function($q) use ($user, $receiver) {
            $q->where('sender_id', $receiver->id)->where('receiver_id', $user->id);
        })->first();

        if ($existingRequest) {
            if ($existingRequest->status === 'pending') {
                return back()->with('error', "A friend request is already pending between you and {$receiver->email}.");
            } elseif ($existingRequest->status === 'accepted') {
                return back()->with('error', "You are already friends with {$receiver->email}.");
            }
            // If declined, you may allow sending a new one or handle differently here
        }

        // Create the friend request with status pending
        FriendRequest::create([
            'sender_id' => $user->id,
            'receiver_id' => $receiver->id,
            'status' => 'pending',
        ]);

        return back()->with('success', "Friend request sent to {$receiver->email}.");
    }

    public function respondRequest(Request $request, $id)
    {
        $user = Auth::user();
        $friendRequest = FriendRequest::where('id', $id)
            ->where('receiver_id', $user->id)
            ->where('status', 'pending')
            ->firstOrFail();

        $action = $request->input('action'); // 'accept' or 'decline'

        if ($action === 'accept') {
            // Update friend request status
            $friendRequest->update(['status' => 'accepted']);

            // Create reciprocal friend records
            Friend::create([
                'user_id' => $friendRequest->sender_id,
                'friend_id' => $friendRequest->receiver_id,
            ]);
            Friend::create([
                'user_id' => $friendRequest->receiver_id,
                'friend_id' => $friendRequest->sender_id,
            ]);

            return back()->with('success', "Friend request accepted.");
        } elseif ($action === 'decline') {
            $friendRequest->update(['status' => 'declined']);
            return back()->with('success', "Friend request declined.");
        } else {
            return back()->with('error', "Invalid action.");
        }
    }



}
