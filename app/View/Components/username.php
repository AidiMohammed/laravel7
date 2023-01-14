<?php

namespace App\View\Components;

use Illuminate\View\Component;

class username extends Component
{
    public $username;
    public $userId;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($username,$userId = null)
    {
        $this->username= $username;
        $this->userId = $userId;
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
