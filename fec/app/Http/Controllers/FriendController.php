<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Friend;
use App\Models\FriendRequest;
use App\Models\Logs;
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

       
        $alreadyFriends = Friend::where(function($q) use ($user, $receiver) {
            $q->where('user_id', $user->id)->where('friend_id', $receiver->id);
        })->orWhere(function($q) use ($user, $receiver) {
            $q->where('user_id', $receiver->id)->where('friend_id', $user->id);
        })->exists();

        if ($alreadyFriends) {
            return back()->with('error', "You are already friends with {$receiver->email}.");
        }

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
        }

        Logs::create([
            'file_id' => null,
            'user_id' => Auth::user()->id,
            'ip_address' => request()->ip(),
            'action' => 'friend add',
        ]);

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

        $action = $request->input('action'); 

        if ($action === 'accept') {
            $friendRequest->update(['status' => 'accepted']);
            Logs::create([
                'file_id' => null,
                'user_id' => Auth::user()->id,
                'ip_address' => request()->ip(),
                'action' => 'friend accept',
            ]);

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
            Logs::create([
                'file_id' => null,
                'user_id' => Auth::user()->id,
                'ip_address' => request()->ip(),
                'action' => 'friend decline',
            ]);
            $friendRequest->update(['status' => 'declined']);
            return back()->with('success', "Friend request declined.");
        } else {
            return back()->with('error', "Invalid action.");
        }
    }

    public function remove(Request $request, $friendId)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $friend = User::find($friendId);
        if (!$friend) {
            return back()->with('error', 'Friend not found.');
        }

        Friend::where(function ($query) use ($user, $friend) {
            $query->where('user_id', $user->id)->where('friend_id', $friend->id);
        })->orWhere(function ($query) use ($user, $friend) {
            $query->where('user_id', $friend->id)->where('friend_id', $user->id);
        })->delete();

        Logs::create([
            'file_id' => null,
            'user_id' => Auth::user()->id,
            'ip_address' => request()->ip(),
            'action' => 'friend remove',
        ]);

        return back()->with('success', "You have removed {$friend->email} from your friends.");
    }
}
