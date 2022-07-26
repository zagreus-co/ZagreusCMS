<?php

if (! function_exists("blogPosts") ) {
    function blogPosts($limit = 10) {
        return \Modules\Blog\Services\BlogPosts::init()
            ->latestPosts($limit);
    }
}