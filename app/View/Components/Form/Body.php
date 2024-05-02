<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Body extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $method;
    public $action;
    
    public function __construct($method=null,$action=null)
    {
      $this->method = $method;
      $this->action = $action;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.body');
    }
}
