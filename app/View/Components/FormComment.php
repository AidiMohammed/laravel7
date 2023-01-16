<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormComment extends Component
{
    public $action;
    public $model;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model =null , $action =null)
    {
        $this->action = $action;
        $this->model = $model;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.form-comment');
    }
}
