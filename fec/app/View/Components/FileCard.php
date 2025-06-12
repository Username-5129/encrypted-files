<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FileCard extends Component
{
    public $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function render(): View|Closure|string
    {
        return view('components.file-card');
    }
}
