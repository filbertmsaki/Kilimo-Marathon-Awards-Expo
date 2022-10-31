<?php

namespace App\View\Components\Web\Layout;

use Illuminate\View\Component;

class AppLayout extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $isPagetitle, $pageTitle;

    public function __construct($isPagetitle, $pageTitle)
    {
        $this->isPagetitle = $isPagetitle;
        $this->pageTitle = $pageTitle;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.web.layout.app-layout');
    }
}
