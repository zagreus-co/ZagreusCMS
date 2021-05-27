<?php
if (! function_exists('get_option')) {
    function get_option($tag, $default = null) {
        try {
            return \Cache::remember('Option::'.$tag.'-'.app()->getLocale(), 14400, function () use ($tag, $default) {
                $option = \Option::whereTag($tag)->first();
                if (is_null($option)) return $default;
                
                return ($option->is_translatable ? $option->data : $option->plain_data);
            });
        } catch (\Throwable $th) {
            return $default;
        }
    }
}

if (! function_exists('update_option')) {
    function update_option($option, $data) {
        if (gettype($option) == 'integer')
            $option = \Option::find($option);
        elseif (gettype($option) == 'string')
            $option = \Option::whereTag($option)->first();
        
        if (is_null($option) || get_class($option) != 'Modules\Option\Entities\Option')
            return false;

        \Cache::forget('Option::'.$option->tag.'-'.app()->getLocale());
        $option->update($data);
        return true;
    }
}
?>
