<?php
if (! function_exists("generateSlug") ) {
    function generateSlug($value, $model, $current = null) {
        $value = \Str::slug($value == '' ? time() : $value);
        $slugCount = $model::whereTranslation('slug', $value);
        if (!is_null($current))
            $slugCount = $slugCount->where('id', '!=', $current);
        if ( $slugCount->count() > 0 )
            $value .= '-'.time();
        return $value;
    }
} 

if (! function_exists("blogPosts") ) {
    function blogPosts($limit = 10) {
        return \Modules\Blog\Entities\Post::wherePublished(1)
            ->orderBy('id', 'desc')
            ->latest()
            ->paginate($limit);
    }
}