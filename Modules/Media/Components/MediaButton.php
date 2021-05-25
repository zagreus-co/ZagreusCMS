<?php

namespace Modules\Media\Components;

use Illuminate\View\Component;

class MediaButton extends Component
{
    public $current;

    public function __construct($current = '') { $this->current = $current; }

    public function render()
    {
        return view('media::components.media-button');
    }
}
