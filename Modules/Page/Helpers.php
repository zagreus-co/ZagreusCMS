<?php
if (! function_exists('activePages') ) {
    function activePages($displayInHeader = true) {
        return \Modules\Page\Entities\Page::wherePublished(1)->whereDisplayInHeader($displayInHeader)->get();
    }
}
?>