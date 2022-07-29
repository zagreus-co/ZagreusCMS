<?php
namespace Modules\Blog\Services;

use Modules\Blog\Entities\Post;

class BlogPosts {
    
    protected static BlogPosts|null $instance = null;
    
    public $model;
    protected $results = [];

    protected function __construct() {
        $this->model = new Post;
    }

    public static function init(): BlogPosts {
        if (is_null(self::$instance)) self::$instance = new self();
        
        return self::$instance;
    }

    public function latestPosts($limit = 10) {
        if (!isset($this->results[__FUNCTION__])) {
            $this->results[__FUNCTION__] = $this->model
                ->wherePublished(1)
                ->with([
                    'category'=> fn($category) => $category->withTranslation(),
                    'medias',
                    'user'
                ])
                ->withTranslation()
                ->orderBy('id', 'desc')
                ->latest()
                ->paginate($limit);
        }
        
        return $this->results[__FUNCTION__];
    }
}