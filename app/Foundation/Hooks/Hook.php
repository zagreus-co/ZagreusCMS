<?php

namespace App\Foundation\Hooks;

abstract class Hook {
    /**
     * Holds the event listeners.
     *
     * @var array
     */
    protected $listeners = [];

    public function __construct() {
        
    }

    /**
     * Builds Unique ID for storage and retrieval.
     *
     * this is exact copy of _wp_filter_build_unique_id function for WordPress 5.8.2.
     * src/wp-includes/plugin.php -> Line 935: _wp_filter_build_unique_id(...)
     * 
     * @param string $hook      Hook name
     * @param mixed  $callback  Function to execute
     * @param int    $priority  Priority of the action
     * @param int    $arguments Number of arguments to accept
     */
    public function generateUniqueId($callback) {
        if ( is_string( $callback ) ) return $callback;
    
        if ( is_object( $callback ) ) {
            // Closures are currently implemented as objects.
            $callback = array( $callback, '' );
        } else {
            $callback = (array) $callback;
        }
    
        if ( is_object( $callback[0] ) ) {
            // Object class calling.
            return spl_object_hash( $callback[0] ) . $callback[1];
        } elseif ( is_string( $callback[0] ) ) {
            // Static calling.
            return $callback[0] . '::' . $callback[1];
        }
    }

    /**
     * Adds a listener.
     *
     * @param string $hook      Hook name
     * @param mixed  $callback  Function to execute
     * @param int    $priority  Priority of the action
     * @param int    $arguments Number of arguments to accept
     */
    public function listen($hook, $callback, $priority = 10, $arguments = 1)
    {
        // Generate unique id for callback to keep track of functions
        $idx = $this->generateUniqueId($callback);
        $this->listeners[$hook][$priority][$idx] = [
            'callback'  => $callback,
            'arguments' => $arguments,
        ];

        return $this;
    }

    /**
     * Removes a listener.
     *
     * @param string $hook     Hook name
     * @param mixed  $callback Function to execute
     * @param int    $priority Priority of the action
     */
    public function remove($hook, $callback, $priority = 10) {
        // this function will complete in future versions
        if (is_array($this->listeners)) {
            
        }
    }

    /**
     * Remove all listeners with given hook in array. If no hook, clear all listeners.
     *
     * @param string $hook Hook name
     */
    public function removeAll($hook = null) {
        if ($hook) {
            if ($this->listeners) {
                $this->listeners[$hook] = [];
            }
        } else {
            // no hook was specified, so clear entire collection
            $this->listeners = [];
        }
    }

    /**
     * Gets a sorted list of all listeners.
     *
     * @param string $hook      Hook name (if nothing passed, returns all listeners)
     * 
     * @return array array of callbacks
     */
    public function getListeners($hook = null)
    {
        if (!is_null($hook)) {
            if (!isset($this->listeners[$hook])) return [];
            ksort($this->listeners[$hook]);
            return $this->listeners[$hook];
        }
        return $this->listeners;
    }

    /**
     * Gets the function.
     *
     * @param mixed $callback Callback
     *
     * @return mixed A closure, an array if "class@method" or a string if "function_name"
     */
    protected function getFunction($callback) {
        if (is_string($callback) && strpos($callback, '@')) {
            $callback = explode('@', $callback);

            return [app('\\'.$callback[0]), $callback[1]];
        } elseif (is_string($callback)) {
            return [app('\\'.$callback), 'handle'];
        } elseif (is_callable($callback)) {
            return $callback;
        } elseif (is_array($callback)) {
            return $callback;
        } else {
            throw new \Exception('$callback is not a Callable', 1);
        }
    }

    /**
     * Fires a new action.
     *
     * @param string $action Name of action
     * @param array  $args   Arguments passed to the action
     */
    abstract public function fire($action, $args);
}