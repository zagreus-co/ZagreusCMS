<?php
namespace Modules\Page\Services;

use Modules\Page\Entities\Page;

class PageService {
    
    protected static PageService|null $instance = null;
    
    public $model;
    protected $results = [];

    protected function __construct() {
        $this->model = new Page;
    }

    public static function init(): PageService {
        if (is_null(self::$instance)) self::$instance = new self();
        
        return self::$instance;
    }

    public function activePages($displayInHeader = true, $limit = 10) {
        if (!isset($this->results[__FUNCTION__])) {
            $this->results[__FUNCTION__] = $this->model
                ->wherePublished(true)
                ->whereDisplayInHeader($displayInHeader)
                ->withTranslation()
                ->limit($limit)
                ->get();
        }
        
        return $this->results[__FUNCTION__];
    }
}