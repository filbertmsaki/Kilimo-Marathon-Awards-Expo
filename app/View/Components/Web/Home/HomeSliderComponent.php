<?php
namespace App\View\Components\Web\Home;
use App\Models\Gallery;
use Illuminate\View\Component;
class HomeSliderComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $galleries  ;
    public function __construct()
    {
        $this->galleries = Gallery::inRandomOrder()->limit(5)->get();
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.web.home.home-slider-component');
    }
}
