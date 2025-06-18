<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Logs;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(File $file)
    {
        $logs = Logs::where('file_id', $file->id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('logs.index', compact('file', 'logs'));
    }
}
