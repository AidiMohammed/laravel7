<?php

namespace App\View\Components;

use Illuminate\View\Component;

class username extends Component
{
    public $username;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($username)
    {
        $this->username= $username;
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
