<?php

if (! function_exists("blogPosts") ) {
    function blogPosts($limit = 10) {
        return \Modules\Blog\Services\BlogPosts::init()
            ->latestPosts($limit);
    }
}

if (! function_exists("sanitizeContent") ) {
    function sanitizeContent($content, $limit = 160) {
        $replace_list = ["&nbsp;"=> " ", "&lt;"=> '<', '&gt;'=> '>', '&amp;'=> '&', '&euro;'=> '€', '&pound;'=> '£', '&quot;'=> '“', '&apos;'=> '‘'];
        return str_replace(array_keys($replace_list), $replace_list, mb_substr( strip_tags($content), 0, $limit) );
    }
}