<?php

namespace App\View\Components\Web\Layout;

use App\Models\Gallery;
use Illuminate\View\Component;

class PageSliderComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $page;
    public $galleries;
    public function __construct($page = null)
    {
        $this->page = $page;
        $this->galleries = Gallery::where('event', $page)->inRandomOrder()->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.web.layout.page-slider-component');
    }
}
