<?php

if (! function_exists("blogPosts") ) {
    function blogPosts($limit = 10) {
        return \Modules\Blog\Entities\Post::wherePublished(1)
            ->orderBy('id', 'desc')
            ->latest()
            ->paginate($limit);
    }
}