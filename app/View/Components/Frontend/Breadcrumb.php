<?php

namespace App\View\Components\Frontend;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Breadcrumb extends Component
{
    public array $links;
    public ?string $title;

    /**
     * Create a new component instance.
     * @param array $links
     * @param ?string $title
     */
    public function __construct($links, $title) {
        $this->links = $links;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.frontend.breadcrumb');
    }
}
