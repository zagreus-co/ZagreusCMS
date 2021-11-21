<?php

namespace App\View\Components\Media;

use Illuminate\View\Component;

class AttachmentInput extends Component
{
    public $current;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($current = '') { $this->current = json_decode($current, true); }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        
        return view('components.media.attachment-input');
    }
}
