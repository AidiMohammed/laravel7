<?php

namespace App\View\Components;

use Illuminate\View\Component;

class username extends Component
{

    public $user;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($user = null)
    {
        $this->user = $user;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.username');
    }
}
