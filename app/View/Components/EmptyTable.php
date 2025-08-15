<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EmptyTable extends Component
{
    public function __construct(
        public string $name,
        public string $route,
        public string $create,
        public string $message,
        public string $colspan,
    ) {
    }

    public function render(): View|Closure|string
    {
        return view('components.empty-table');
    }
}
