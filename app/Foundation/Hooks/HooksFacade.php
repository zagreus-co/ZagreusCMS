<?php
namespace App\Foundation\Hooks;

use Illuminate\Support\Facades\Facade;

class HooksFacade extends Facade {
    protected static function getFacadeAccessor() {
        return 'Hooks';
    }
}
