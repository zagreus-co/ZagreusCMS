<?php

namespace Modules\Media\Components;

use Illuminate\View\Component;

class AttachmentInput extends Component
{
    public $current;

    public function __construct($current = '') { $this->current = json_decode($current, true); }

    public function render()
    {
        return view('media::components.attachment-input');
    }
}
