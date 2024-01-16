<?php

use Illuminate\Support\Facades\Gate;

// Panel-User helpers
if (!function_exists('checkGate')) {
    function checkGate($gate)
    {
        if (gettype($gate) == 'array') {
            foreach ($gate as $value) {
                if (Gate::allows($value)) return true;
            }
            return false;
        }

        if (gettype($gate) == 'string') return Gate::allows($gate);

        echo 'error@Helpers::checkGate : Wrong gate type';
        return false;
    }
}
