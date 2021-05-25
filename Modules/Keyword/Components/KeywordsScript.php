<?php

namespace Modules\Keyword\Components;

use Illuminate\View\Component;

class KeywordsScript extends Component
{

    public function __construct() { }

    public function render()
    {
        return view('keyword::components.keywords-script');
    }
}
