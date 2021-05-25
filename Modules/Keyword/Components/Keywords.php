<?php

namespace Modules\Keyword\Components;

use Illuminate\View\Component;

class Keywords extends Component
{
    public $parent;
    public $child;
    public $inputClass;
    public $current;
    public function __construct($parent = 'form-group', $child = '', $inputClass = 'form-control', $current = '[]')
    {
        $this->parent = $parent;
        $this->child = $child;
        $this->inputClass = $inputClass;
        $this->current = json_decode($current, true);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('keyword::components.keywords');
    }
}
