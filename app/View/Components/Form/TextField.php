<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class TextField extends Component
{

  public string $name;
  public string $type;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $name,string $type='text')
    {
        $this->name = $name;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.text-field');
    }
}
