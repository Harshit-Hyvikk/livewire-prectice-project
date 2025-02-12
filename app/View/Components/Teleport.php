<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Teleport extends Component
{
    public $to;

    public function __construct($to)
    {
        $this->to = $to;
    }

    public function render()
    {
        return view('components.teleport');
    }
}
