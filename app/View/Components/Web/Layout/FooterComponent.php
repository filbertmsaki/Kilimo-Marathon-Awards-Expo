<?php

namespace App\View\Components\Web\Layout;

use App\Models\Gallery;
use Illuminate\View\Component;

class FooterComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $galleries ;
    public function __construct()
    {
        $this->galleries = Gallery::inRandomOrder()->limit(12)->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.web.layout.footer-component');
    }
}
