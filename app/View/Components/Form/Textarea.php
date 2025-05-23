<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Textarea extends Component
{

  public $name;
  public $rows;
  public $cols;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name,$rows,$cols)
    {
      $this->name= $name;
      $this->rows = $rows;
      $this->cols = $cols;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.textarea');
    }
}
