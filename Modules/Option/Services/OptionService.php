<?php
namespace Modules\Option\Services;

class OptionService {
    public function __construct() {
        return new \Modules\Option\Entities\Option();
    }
}
