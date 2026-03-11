<?php

namespace App\View\Components;

use App\Models\Navigation;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SiteNavigation extends Component
{
    public function __construct(
        public string $location,
        public string $class = ''
    ) {
    }

    public function render(): View|Closure|string
    {
        return view('components.site-navigation', [
            'navigation' => Navigation::publishedForLocation($this->location),
        ]);
    }
}
