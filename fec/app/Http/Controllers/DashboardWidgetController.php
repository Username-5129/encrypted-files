<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardWidgetController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();
        $user->dashboard_widgets_settings = $request->input('widgets', []);
        $user->save();

        return back()->with('success', 'Dashboard settings updated!');
    }
}
