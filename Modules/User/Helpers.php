<?php
if (!function_exists('checkGate')) {
    function checkGate($gate) {
        if (gettype($gate) == 'array') {
            foreach($gate as $value) {
                if (\Gate::allows($value)) return true;
            }
            return false;
        }
        if (gettype($gate) == 'string') {
            return \Gate::allows($gate);
        }
        echo 'error@Modules.User.Helpers : Wrong gate type';
        return false;
    }
}