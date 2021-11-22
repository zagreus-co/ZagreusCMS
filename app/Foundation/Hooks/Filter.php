<?php

namespace App\Foundation\Hooks;

class Filter extends Hook {
    protected $value = '';

    /**
     * Filters a value.
     *
     * @param string $action Name of filter
     * @param array  $args   Arguments passed to the filter
     *
     * @return string Always returns the value
     */
    public function fire($action, $args)
    {
        $this->value = isset($args[0]) ? $args[0] : ''; // get the value, the first argument is always the value

        if ($this->getListeners($action)) {
            foreach($this->getListeners($action) as $hooks) {
                foreach($hooks as $hook) {
                    $parameters = [];
                    for ($i = 0; $i < $hook['arguments']; $i++) {
                        $value = $args[$i] ?? null;
                        $parameters[] = $value;
                    }
                    $this->value = call_user_func_array($this->getFunction($hook['callback']), $parameters);
                }
            }
        }

        return $this->value;
    }
}