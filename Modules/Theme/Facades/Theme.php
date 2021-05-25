<?php
namespace Modules\Theme\Facades;

use Illuminate\Support\Facades\Facade;


class Theme extends Facade{
    protected static function getFacadeAccessor() {
        return 'Theme';
    }
}
