<?php

namespace Modules\Media\Components;

use Illuminate\View\Component;

class UploadInput extends Component
{
    public $current;

    public function __construct($current = '') { $this->current = $current; }

    public function render()
    {
        return view('media::components.upload-input');
    }
}
