<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\HomepageSetting;
use App\Models\File;
use App\Models\Activity;
use App\Models\Logs;

class HomeController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return view('guest_home');
        }
        
        $user = Auth::user();
        $settings = $user->homepageSetting ?? HomepageSetting::firstOrCreate(['user_id' => $user->id]);

        $recentFiles = File::where('owner_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $friends = $user->friends ?? collect();

        $friendActivity = collect();
        if ($friends->isNotEmpty()) {
            $friendActivity = File::whereIn('owner_id', $friends->pluck('id'))
                ->latest()
                ->take(10)
                ->get();
        }

        return view('home', compact('settings', 'recentFiles', 'friendActivity', 'friends'));
    }

    public function updateSettings(Request $request)
    {
        Logs::create([
            'file_id' => null,
            'user_id' => Auth::user()->id,
            'ip_address' => request()->ip(),
            'action' => 'homepage edit',
        ]);
        $user = Auth::user();
        $settings = $user->homepageSetting ?? new HomepageSetting(['user_id' => $user->id]);
        $settings->show_recent_files = $request->has('show_recent_files');
        $settings->show_friend_activity = $request->has('show_friend_activity');
        $settings->theme = $request->input('theme', 'light');
        $settings->layout = $request->input('layout', 'grid');
        $settings->save();

        return redirect()->back()->with('success', 'Homepage settings updated!');
    }
}
