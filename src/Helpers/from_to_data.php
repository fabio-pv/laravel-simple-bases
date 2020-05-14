<?php

if (!function_exists('from_to_data')) {
    function from_to_data($param = null)
    {
        return config('from_to_data')[get_class($param)];
    }
}
