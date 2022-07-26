<?php

if (! function_exists("blogPosts") ) {
    function blogPosts($limit = 10) {
        return \Modules\Blog\Services\BlogPosts::init()
            ->model
            ->wherePublished(1)
            ->with('medias')
            ->orderBy('id', 'desc')
            ->latest()
            ->paginate($limit);
    }
}