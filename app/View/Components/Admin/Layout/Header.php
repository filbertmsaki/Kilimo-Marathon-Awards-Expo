<?php

namespace App\View\Components\Admin\Layout;

use Illuminate\View\Component;
use App\Models\Message\Thread as MessageThread;


class Header extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $unread_messages ;
    public function __construct()
    {
        $this->unread_messages = MessageThread::forUserWithNewMessages(auth()->user()->id)->latest('updated_at')->paginate(3);;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.layout.header');
    }
}
