<?php

namespace App\Foundation\Hooks;

class Action extends Hook {
    /**
     * Actions a hook.
     *
     * @param string $action Name of action
     * @param array  $args   Arguments passed to the filter
     *
     * @return string Always returns the value
     */
    public function fire($action, $args)
    {
        if ($this->getListeners($action)) {
            foreach($this->getListeners($action) as $hooks) {
                foreach($hooks as $hook) {
                    $parameters = [];
                    for ($i = 0; $i < $hook['arguments']; $i++) {
                        $value = $args[$i] ?? null;
                        $parameters[] = $value;
                    }
                    call_user_func_array($this->getFunction($hook['callback']), $parameters);
                }
            }
        }
    }
}