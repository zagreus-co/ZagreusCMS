<?php

if ( !function_exists('locales') ) {
    function locales() { return config('app.available_locales'); }
}