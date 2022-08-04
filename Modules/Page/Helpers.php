<?php
if (! function_exists('activePages') ) {
    function activePages($displayInHeader = true) {
        return \Modules\Page\Services\PageService::init()
            ->activePages($displayInHeader);
    }
}
?>