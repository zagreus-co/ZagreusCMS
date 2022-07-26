<?php
namespace Modules\Blog\Services;

use Modules\Blog\Entities\Post;

class BlogPosts {
    
    protected static BlogPosts|null $instance = null;
    
    public $model;

    protected function __construct() {
        $this->model = new Post;
    }

    public static function init(): BlogPosts {
        if (is_null(self::$instance)) self::$instance = new self();
        
        return self::$instance;
    }
}